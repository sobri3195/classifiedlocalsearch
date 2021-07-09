package com.way.magictips;



import java.io.File;
import java.io.IOException;
import java.util.ArrayList;
import java.util.Collections;
import java.util.HashMap;
import java.util.LinkedList;
import java.util.List;

import org.json.JSONArray;
import org.json.JSONObject;

import util.common.Util;
import util.imageLoader.ImageLoader.Quality;


import com.nostra13.universalimageloader.core.DisplayImageOptions;
import com.nostra13.universalimageloader.core.ImageLoader;
import com.nostra13.universalimageloader.core.ImageLoaderConfiguration;
import com.nostra13.universalimageloader.core.assist.ImageScaleType;
import com.nostra13.universalimageloader.core.display.FadeInBitmapDisplayer;
import com.nostra13.universalimageloader.core.display.SimpleBitmapDisplayer;
import com.nostra13.universalimageloader.core.listener.ImageLoadingListener;
import com.nostra13.universalimageloader.core.listener.SimpleImageLoadingListener;
import com.nostra13.universalimageloader.utils.StorageUtils;

import com.way.magictrik.R;

import defaultconfig.ConstValue;
import framework.ConnectionDetector;
import framework.ObjectSerializer;
import android.app.Activity;
import android.app.AlertDialog;
import android.app.ProgressDialog;
import android.content.Context;
import android.content.Intent;
import android.content.SharedPreferences;
import android.database.Cursor;
import android.database.SQLException;
import android.database.sqlite.SQLiteDatabase;
import android.graphics.Bitmap;
import android.os.AsyncTask;
import android.os.Bundle;
import android.support.v4.app.Fragment;
import android.text.Editable;
import android.text.TextWatcher;
import android.util.Log;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.view.View.OnClickListener;
import android.webkit.WebView.FindListener;
import android.widget.AdapterView;
import android.widget.BaseAdapter;
import android.widget.ImageView;
import android.widget.ListView;
import android.widget.TextView;
import android.widget.Toast;
import android.widget.AdapterView.OnItemClickListener;
import json.JSONParser;
import framework.BaseActivity;

import org.json.JSONArray;
import org.json.JSONObject;


public class CompanyList extends Fragment implements OnItemClickListener,OnClickListener{
	
	static Context context1;
	static Activity act1;
	companyListAdapter mca;
	ListView lst3;

	//SQLiteDatabase db1;
	AlertDialog.Builder loadingBuilder;
	AlertDialog loadingDialog;
	

	// Internet detector
	ConnectionDetector cd;
	
	View progressBar;
	final String PREFS_NAME = "MyPrefsFile";
	SharedPreferences settings;
	ArrayList<HashMap<String, String>> compList = new ArrayList<HashMap<String,String>>();
	
	private ImageLoadingListener animateFirstListener = new AnimateFirstDisplayListener();
	DisplayImageOptions options;
	ImageLoaderConfiguration imgconfig; 
	
	
	public static Fragment newInstance(Context context,Activity asAct) {
		CompanyList f = new CompanyList();	
		context1=context;
		act1=asAct;
		
		return f;
	}
	
	@Override
	public View onCreateView(LayoutInflater inflater, ViewGroup container,Bundle savedInstanceState) {
		ViewGroup root = (ViewGroup) inflater.inflate(R.layout.company_list, null);	
		
File cacheDir = StorageUtils.getCacheDirectory(context1);
		
		options = new DisplayImageOptions.Builder()
		.showImageOnLoading(R.drawable.loader)
		.showImageForEmptyUri(R.drawable.loader)
		.showImageOnFail(R.drawable.loader)
		.cacheInMemory(true)
		.cacheOnDisk(true)
		.considerExifParams(true)
		.displayer(new SimpleBitmapDisplayer())
		.imageScaleType(ImageScaleType.EXACTLY)
		.build();
		
		imgconfig = new ImageLoaderConfiguration.Builder(context1)
		.build();
		ImageLoader.getInstance().init(imgconfig);
		
		settings = this.getActivity().getSharedPreferences(PREFS_NAME, 0);
		progressBar = (View)root.findViewById(R.id.progressBarView);
		progressBar.setVisibility(View.GONE);
		
		try {
			if(ConstValue.SEARCH_TEXT.equalsIgnoreCase(""))
				compList = (ArrayList<HashMap<String,String>>) ObjectSerializer.deserialize(settings.getString(ConstValue.PREF_COMPANYIES+ConstValue.sel_category.get("id"), ObjectSerializer.serialize(new ArrayList<HashMap<String,String>>())));
			else
			compList = (ArrayList<HashMap<String,String>>) ObjectSerializer.deserialize(settings.getString(ConstValue.PREF_COMPANYIES+"search"+ConstValue.sel_category.get("id"), ObjectSerializer.serialize(new ArrayList<HashMap<String,String>>())));		
		}catch (IOException e) {
			    e.printStackTrace();
		}
		
	
		
		lst3=(ListView)root.findViewById(R.id.listView1);
		
		 cd = new ConnectionDetector(context1);
		 
			
		 mca = new companyListAdapter(context1,compList, act1);
			lst3.setAdapter(mca);
			lst3.setOnItemClickListener(this);
		
			
		new MainMenuTask().execute(true);
		
//			ViewGroup rootParent = (ViewGroup) inflater.inflate(R.layout.activity_company_main, null);	
//			final TextView txtSearch = (TextView)rootParent.findViewById(R.id.txtsearch);
//			txtSearch.addTextChangedListener(new TextWatcher() {
//				
//				public void onTextChanged(CharSequence s, int start, int before, int count) {
//					// TODO Auto-generated method stub
//					String searchString=txtSearch.getText().toString();
//			        int textLength=searchString.length();
//			       if (textLength!=0) {
//					
//				    ArrayList<HashMap<String, String>> searchList = new ArrayList<HashMap<String,String>>();
//					for (int i = 0; i < compList.size(); i++) {
//						  String rname = compList.get(i).get("company").toString();
//		                  if(textLength<=rname.length())
//		                  {
//		                	  if(searchString.equalsIgnoreCase(rname.substring(0,textLength)))
//		                      {
//		                		  searchList.add(compList.get(i));
//		                      }
//		                             
//		                  }
//					}
//			       
//					mca = new companyListAdapter(context1,searchList, act1);
//					lst3.setAdapter(mca);
//			       }else{
//			    	   mca = new companyListAdapter(context1,compList, act1);
//			    	   lst3.setAdapter(mca);
//					
//			       }
//				}
//				
//				public void beforeTextChanged(CharSequence s, int start, int count,
//						int after) {
//					// TODO Auto-generated method stub
//					
//				}
//				
//				public void afterTextChanged(Editable s) {
//					// TODO Auto-generated method stub
//					
//				}
//			});
			
		return root;
	}
	
	
									
	     
	 public void setRefreshData()
		{
			mca.notifyDataSetChanged();
		}
	//------------------ADAPTER FOR COMPANY----------------//
    public class companyListAdapter extends BaseAdapter{
    	Context act;
    	private LayoutInflater inflater=null;
    	ArrayList<HashMap<String, String>> data;
    	
    	public companyListAdapter(Context a,ArrayList<HashMap<String, String>> maincat,Activity ac1){
    		act = a;
    		
    		data = maincat;
    		inflater = (LayoutInflater)ac1.getSystemService(Context.LAYOUT_INFLATER_SERVICE);
    	}
		public int getCount() {
			// TODO Auto-generated method stub
			return data.size();
		}

		public Object getItem(int position) {
			// TODO Auto-generated method stub
			return null;
		}

		public long getItemId(int position) {
			// TODO Auto-generated method stub
			return 0;
		}

		public View getView(int position, View convertView, ViewGroup parent) {
			// TODO Auto-generated method stub
			 View vi=convertView;
		        if(convertView==null)
		            vi = inflater.inflate(R.layout.row_company_list, null);
	        
		        HashMap<String, String> map = new HashMap<String, String>();
		        map = data.get(position);
		       TextView txt = (TextView)vi.findViewById(R.id.textMaincat);
		        String title = map.get("company");
		        if(map.get("company").length()>20)
		        {
		        	title = map.get("company").substring(0, 20) + "..";
		        }
		        String upperString = title.substring(0,1).toUpperCase() + title.substring(1).toLowerCase();
		        txt.setText(upperString);
		        TextView txtCity = (TextView)vi.findViewById(R.id.textCity);
		        txtCity.setText(map.get("address"));
		        
		        TextView txtWeb = (TextView)vi.findViewById(R.id.TextWeb);
		        txtWeb.setText(map.get("website"));
		        
		        TextView txtPhone = (TextView)vi.findViewById(R.id.textPhone);
		        txtPhone.setText(map.get("phone1"));
		        
		        TextView txtFax = (TextView)vi.findViewById(R.id.TextFax);
		        txtFax.setText(map.get("fax"));
		        
		        ImageView imgView = (ImageView)vi.findViewById(R.id.imageThumb);
		        if(!map.get("image").equals(""))
		        	ImageLoader.getInstance().displayImage(map.get("image"), imgView, options, animateFirstListener);
		        	//imgloader.DisplayImage(map.get("image"), act1, imgView);
		        
		        else
		        	imgView.setImageResource(R.drawable.no_logo);
		        //imgView.setImageURI(URI(map.get("image")));
		        //aq.id(vi).id(R.id.imageThumb).image(map.get("image"),false,true);
		        //aq.id(vi).id(R.id.textMaincat).text(map.get("name"));
		        
		        return vi;
		}
		
    }

    
	public void onClick(View v) {
		// TODO Auto-generated method stub
		
	}

	 public void onItemClick(AdapterView<?> parent, View view, int position, long id) {
			// TODO Auto-generated method stub
		 Log.d("parent", ""+parent);
		// ConstValue.SELECTED_COMPANY_ID = Integer.parseInt(compList.get(position).get("id"));
			
			Intent intent = new Intent(context1,CompanyDetails.class);
			ConstValue.sel_company = compList.get(position);
			startActivity(intent);
		}

	@Override
	public void onDestroyView() {
		// TODO Auto-generated method stub
		
		super.onDestroyView();
	}
	
//	public void LoadingDialogBox(String open)
//	{
//		  if(open=="open")
//		  {
//				loadingBuilder = new AlertDialog.Builder(context1);  
//				loadingBuilder.setTitle("Loading wait...");  
//		       //final TextView input = new TextView(this);  
//		    
//		       //input.setText("Loading please wait.."); //Set the text we want to edit  
//		       
//		       View myView = null;
//		       myView = getLayoutInflater().inflate(R.layout.progressbar_view, null);
//		       
//		       loadingBuilder.setView(myView);        
//		        
//		       // Remember, create doesn't show the dialog  
//		       loadingDialog = loadingBuilder.create();  
//		       loadingDialog.show();  
//		  }else if(open=="close")
//		  {
//			  loadingDialog.cancel();
//		  }
//	}

	
	public class MainMenuTask extends AsyncTask<Boolean, Void, ArrayList<HashMap<String, String>>> {

		JSONParser jParser;
		JSONObject json;
		
		@Override
		protected void onPreExecute() {
			// TODO Auto-generated method stub
			progressBar.setVisibility(View.GONE);
			super.onPreExecute();
		}

		@Override
		protected void onPostExecute(ArrayList<HashMap<String, String>> result) {
			// TODO Auto-generated method stub
			if (result!=null) {
				
				//adapter.notifyDataSetChanged();
			}
			
			try {
				if(ConstValue.SEARCH_TEXT.equalsIgnoreCase(""))
				settings.edit().putString(ConstValue.PREF_COMPANYIES+ConstValue.sel_category.get("id"),ObjectSerializer.serialize(compList)).commit();
				else
					settings.edit().putString(ConstValue.PREF_COMPANYIES+"search"+ConstValue.sel_category.get("id"),ObjectSerializer.serialize(compList)).commit();
			} catch (IOException e) {
				// TODO Auto-generated catch block
				e.printStackTrace();
			}
			mca.notifyDataSetChanged();
			
			progressBar.setVisibility(View.GONE);
			super.onPostExecute(result);
		}

		@Override
		protected void onProgressUpdate(Void... values) {
			// TODO Auto-generated method stub
			super.onProgressUpdate(values);
		}

		
	
		@Override
		protected ArrayList<HashMap<String, String>> doInBackground(
				Boolean... params) {
			// TODO Auto-generated method stub
			try {
				jParser = new JSONParser();
				
				if(cd.isConnectingToInternet())
				{
					
					//progressBar.setVisibility(View.VISIBLE);
					if(ConstValue.SEARCH_TEXT.equalsIgnoreCase("")){
					json = jParser.getJSONFromUrl(ConstValue.JSON_COMPANI+ConstValue.sel_category.get("id"));
					}else
					{
						json = jParser.getJSONFromUrl(ConstValue.JSON_COMPANI_SEARCH+ConstValue.sel_category.get("id")+"&s="+ConstValue.SEARCH_TEXT);
					}
					JSONArray menus = json.getJSONArray("companies");
					if(menus!=null)
					{
						compList.clear();
						for (int i = 0; i < menus.length(); i++) {
							JSONObject c = menus.getJSONObject(i);
							HashMap<String, String> map = new HashMap<String, String>();
							map.put("id",c.getString("id"));
							map.put("category",c.getString("category"));
							map.put("company",c.getString("company"));
							map.put("address",c.getString("address"));
							
							map.put("city",c.getString("city"));
							map.put("state",c.getString("state"));
							map.put("zip",c.getString("zip"));
							
							map.put("website",c.getString("website"));
							map.put("fax",c.getString("fax"));
							map.put("phone1",c.getString("phone1"));
							
							map.put("phone2",c.getString("phone2"));
							map.put("key_person1",c.getString("key_person1"));
							map.put("key_person2",c.getString("key_person2"));
							
							map.put("email1",c.getString("email1"));
							map.put("email2",c.getString("email2"));
							map.put("longitude",c.getString("longitude"));
							
							map.put("latitude",c.getString("latitude"));
							map.put("android",c.getString("android"));
							map.put("iphone",c.getString("iphone"));
							
							map.put("content",c.getString("content"));
							map.put("image",ConstValue.CONTENTS_IMAGE+"small/"+c.getString("logo"));
							map.put("banner",c.getString("banner"));
							map.put("status",c.getString("status"));
							
							map.put("order",c.getString("order"));
							map.put("special",c.getString("special"));
							map.put("top",c.getString("top"));

							compList.add(map);
						}
						
					}
					
				}else
				{
					//Toast.makeText(context1, "Please connect mobile with working Internet", Toast.LENGTH_LONG).show();
				}
					
				// TODO Auto-generated method stub
				// Getting Array of Size
						
				
			jParser = null;
			json = null;
			
				} catch (Exception e) {
					// TODO: handle exception
					
					return null;
				}
			return null;
		}

	}
}
class AnimateFirstDisplayListener extends SimpleImageLoadingListener {

	final List<String> displayedImages = Collections.synchronizedList(new LinkedList<String>());

	@Override
	public void onLoadingComplete(String imageUri, View view, Bitmap loadedImage) {
		if (loadedImage != null) {
			ImageView imageView = (ImageView) view;
			boolean firstDisplay = !displayedImages.contains(imageUri);
			if (firstDisplay) {
				FadeInBitmapDisplayer.animate(imageView, 500);
				displayedImages.add(imageUri);
			}
		}
	}
}
