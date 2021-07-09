package com.way.magictips;



import java.util.ArrayList;
import java.util.HashMap;

import org.json.JSONArray;
import org.json.JSONObject;

import util.common.Util;
import util.imageLoader.ImageLazyLoader;
import util.imageLoader.ImageLoader;





import com.way.magictrik.R;

import defaultconfig.ConstValue;
import framework.ConnectionDetector;
import android.app.Activity;
import android.app.AlertDialog;
import android.app.ProgressDialog;
import android.content.Context;
import android.content.Intent;
import android.database.Cursor;
import android.database.SQLException;
import android.database.sqlite.SQLiteDatabase;
import android.os.AsyncTask;
import android.os.Bundle;
import android.support.v4.app.Fragment;
import android.util.Log;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.view.View.OnClickListener;
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


public class CompanyList2 extends Fragment implements OnItemClickListener,OnClickListener{

	SQLiteDatabase db;
	static Context context1;
	companyListAdapter mca;
	ListView lst1;
	static Activity act1;
	//SQLiteDatabase db1;
	Cursor cr;


	// Internet detector
	ConnectionDetector cd;
	
	View progressBar;
	
	
	public static Fragment newInstance(Context context,Activity asAct) {
		CompanyList2 f = new CompanyList2();	
		context1=context;
		
		act1=asAct;
	
		
		return f;
	}

	@Override
	public View onCreateView(LayoutInflater inflater, ViewGroup container,Bundle savedInstanceState) {
		ViewGroup root = (ViewGroup) inflater.inflate(R.layout.company_list_2, null);	
		db = SQLiteDatabase.openDatabase(ConstValue.DATABASE_URL, null,  SQLiteDatabase.OPEN_READWRITE |  SQLiteDatabase.NO_LOCALIZED_COLLATORS);
		progressBar = (View)root.findViewById(R.id.progressBarView);
		progressBar.setVisibility(View.GONE);
		
		lst1=(ListView)root.findViewById(R.id.listView1);
		
		Log.d("Selected Cat :", ConstValue.SELECTED_MAINCATEGORY_ID );
		
		cr = db.rawQuery("select * from `company` where id in (select `company` from `relation` where `category`='"+ConstValue.SELECTED_MAINCATEGORY_ID+"') AND `top`='1' ORDER BY `order`",null);
		{
			if(cr.getCount()>0)
			{
					LoadFromDatabase(cr);
			}
			else
			{
				//Toast.makeText(context1, "No Detail Available", Toast.LENGTH_LONG).show();
			}
		}
		cr.close();
		
		mca = new companyListAdapter(context1, ConstValue.compList2);
		lst1.setAdapter(mca);
		lst1.setOnItemClickListener(this);
		
		 cd = new ConnectionDetector(context1);
		 
			// Check if Internet present
			if (!cd.isConnectingToInternet()) {
				// Internet Connection is not present
				
			}else{
				
			}
				//new companyListAsyTask().execute();
		
		db.close();
		return root;
	}
	
	
//	 class companyListAsyTask extends AsyncTask<Void, Void, HashMap<String, ArrayList<HashMap<String, String>>>>{
//
//			@Override
//			protected HashMap<String, ArrayList<HashMap<String, String>>> doInBackground(
//					Void... params) {
//				// TODO Auto-generated method stub
//				try
//				{
//				JSONParser jParser = new JSONParser();
//				JSONObject json = jParser.getJSONFromUrl(ConstValue.JSON_COMPANI_COUNT+ConstValue.SELECTED_MAINCATEGORY_ID);
//				
//				
//				
//				
//				
//				int  catcount = json.getInt("companies");
//				
//				
//				
//				cr = db.rawQuery("select * from `company` where `category`='"+ConstValue.SELECTED_MAINCATEGORY_ID+"'",null);
//				{
//					if(cr!=null)
//					{
//						Log.d("data match", ""+catcount+"=="+cr.getCount());
//						if(catcount!=cr.getCount())
//	 				  {
//							Log.d("load company from webservice", "");
//							json = jParser.getJSONFromUrl(ConstValue.JSON_COMPANI+ConstValue.SELECTED_MAINCATEGORY_ID);
//							
//							JSONArray concepts = json.getJSONArray("companies");
//							if(concepts!=null)
//							{
//								db.beginTransaction();
//								
//								
//							for(int i = 0; i < concepts.length(); i++){
//								JSONObject c = concepts.getJSONObject(i);
//								Cursor cr1 = db.rawQuery("select * from `company` where `id`='"+c.getString("id")+"' limit 1",null);
//								if(cr1!=null)
//								{
//									if(cr1.getCount()>0){
//								
//									}else
//									{
//									String query ="INSERT OR REPLACE into company(id,category,company,address,city,state,zip,website,fax,phone1,phone2,key_person1,key_person2,email1,email2,longitude,latitude,android,iphone,content,logo,banner,`status`,`order`,`special`,top)"+
//										"values('"+
//										c.getString("id")+"','"+
//										c.getString("category")+"','"+
//										c.getString("company")+"','"+
//										c.getString("address")+"','"+
//										c.getString("city")+"','"+
//										c.getString("state")+"','"+
//										c.getString("zip")+"','"+
//										c.getString("website")+"','"+
//										c.getString("fax")+"','"+
//										c.getString("phone1")+"','"+
//										c.getString("phone2")+"','"+
//										c.getString("key_person1")+"','"+
//										c.getString("key_person2")+"','"+
//										c.getString("email1")+"','"+
//										c.getString("email2")+"','"+
//										c.getString("longitude")+"','"+
//										c.getString("latitude")+"','"+
//										c.getString("android")+"','"+
//										c.getString("iphone")+"','"+
//										c.getString("content")+"','"+
//										c.getString("logo")+"','"+
//										c.getString("banner")+"','"+
//										c.getString("status")+"','"+
//										c.getString("order")+"','"+
//										c.getString("special")+"','"+
//										c.getString("top")+"'"+
//										") ";
//									db.execSQL(query);
//									Log.d("Insert","company"+c.getString("id"));
//									
//HashMap<String, String> map = new HashMap<String, String>();
//									
//									map.put("id",c.getString("id"));
//									map.put("category",c.getString("category"));
//									map.put("company",c.getString("company"));
//									map.put("address",c.getString("address"));
//									
//									map.put("city",c.getString("city"));
//									map.put("state",c.getString("state"));
//									map.put("zip",c.getString("zip"));
//									
//									map.put("website",c.getString("website"));
//									map.put("fax",c.getString("fax"));
//									map.put("phone1",c.getString("phone1"));
//									
//									map.put("phone2",c.getString("phone2"));
//									map.put("key_person1",c.getString("key_person1"));
//									map.put("key_person2",c.getString("key_person2"));
//									
//									map.put("email1",c.getString("email1"));
//									map.put("email2",c.getString("email2"));
//									map.put("longitude",c.getString("longitude"));
//									
//									map.put("latitude",c.getString("latitude"));
//									map.put("android",c.getString("android"));
//									map.put("iphone",c.getString("iphone"));
//									
//									map.put("content",c.getString("content"));
//									map.put("image",ConstValue.CONTENTS_IMAGE+"small/"+c.getString("logo"));
//									map.put("banner",ConstValue.CONTENTS_IMAGE+"big/"+c.getString("banner"));
//									map.put("status",c.getString("status"));
//									
//									map.put("order",c.getString("order"));
//									map.put("special",c.getString("special"));
//									map.put("top",c.getString("top"));
//									
//									compList.add(map);
//									}
//								}else
//								{
//									String query ="INSERT OR REPLACE into company(id,category,company,address,city,state,zip,website,fax,phone1,phone2,key_person1,key_person2,email1,email2,longitude,latitude,android,iphone,content,logo,banner,`status`,`order`,`special`,top)"+
//											"values('"+
//											c.getString("id")+"','"+
//											c.getString("category")+"','"+
//											c.getString("company")+"','"+
//											c.getString("address")+"','"+
//											c.getString("city")+"','"+
//											c.getString("state")+"','"+
//											c.getString("zip")+"','"+
//											c.getString("website")+"','"+
//											c.getString("fax")+"','"+
//											c.getString("phone1")+"','"+
//											c.getString("phone2")+"','"+
//											c.getString("key_person1")+"','"+
//											c.getString("key_person2")+"','"+
//											c.getString("email1")+"','"+
//											c.getString("email2")+"','"+
//											c.getString("longitude")+"','"+
//											c.getString("latitude")+"','"+
//											c.getString("android")+"','"+
//											c.getString("iphone")+"','"+
//											c.getString("content")+"','"+
//											c.getString("logo")+"','"+
//											c.getString("banner")+"','"+
//											c.getString("status")+"','"+
//											c.getString("order")+"','"+
//											c.getString("special")+"','"+
//											c.getString("top")+"'"+
//											") ";
//										db.execSQL(query);
//										Log.d("Insert","company"+c.getString("id"));
//										
//	HashMap<String, String> map = new HashMap<String, String>();
//										
//										map.put("id",c.getString("id"));
//										map.put("category",c.getString("category"));
//										map.put("company",c.getString("company"));
//										map.put("address",c.getString("address"));
//										
//										map.put("city",c.getString("city"));
//										map.put("state",c.getString("state"));
//										map.put("zip",c.getString("zip"));
//										
//										map.put("website",c.getString("website"));
//										map.put("fax",c.getString("fax"));
//										map.put("phone1",c.getString("phone1"));
//										
//										map.put("phone2",c.getString("phone2"));
//										map.put("key_person1",c.getString("key_person1"));
//										map.put("key_person2",c.getString("key_person2"));
//										
//										map.put("email1",c.getString("email1"));
//										map.put("email2",c.getString("email2"));
//										map.put("longitude",c.getString("longitude"));
//										
//										map.put("latitude",c.getString("latitude"));
//										map.put("android",c.getString("android"));
//										map.put("iphone",c.getString("iphone"));
//										
//										map.put("content",c.getString("content"));
//										map.put("image",ConstValue.CONTENTS_IMAGE+"small/"+c.getString("logo"));
//										map.put("banner",ConstValue.CONTENTS_IMAGE+"big/"+c.getString("banner"));
//										map.put("status",c.getString("status"));
//										
//										map.put("order",c.getString("order"));
//										map.put("special",c.getString("special"));
//										map.put("top",c.getString("top"));
//										
//										compList.add(map);
//								}
//									
//							}
//							}
//
//							db.setTransactionSuccessful();
//							Log.d("transaction success", "in online data lod of company");
//							db.endTransaction();
//	 				  }
//						
//							cr.close();
//						cr = db.rawQuery("select * from `company` where id in (select `company` from `relation` where `category`='"+ConstValue.SELECTED_MAINCATEGORY_ID+"') AND `top`='1' ORDER BY `order`",null);
//
//							LoadFromDatabase(cr);
//						
//						
//						}
//					}
//				cr.close();
//				//db.setTransactionSuccessful();
//				Log.d("transaction success", "in online data lod of company");
//				//db.endTransaction();
//				//db.close();
//				}
//				 catch (Exception e) {
//						// TODO Auto-generated catch block
//						e.printStackTrace();
//						//cr.close();
//						//db.close();
//					}
//
//						HashMap<String, ArrayList<HashMap<String, String>>> aMap = new HashMap<String, ArrayList<HashMap<String,String>>>();
//						aMap.put(ConstValue.SELECTED_MAINCATEGORY_ID, compList);
//						//mCatlist.add( Integer.parseInt(ConstValue.SELECTED_MAINCATEGORY_ID),aMap);
//						
//				return aMap;
//			}
//
//			@Override
//			protected void onCancelled() {
//				// TODO Auto-generated method stub
//				super.onCancelled();
//			}
//
//			@Override
//			protected void onPostExecute(HashMap<String, ArrayList<HashMap<String, String>>> result) {
//				// TODO Auto-generated method stub
//				
//	//		LoadingDialogBox("close");
//				if (result == null) {
//					Util.alertbox(context1,getString(R.string.message));
//					return;
//				}
//				//ArrayList<HashMap<String, ArrayList<HashMap<String, String>>>> mCList = new ArrayList<HashMap<String,ArrayList<HashMap<String,String>>>>();
//				//mCList =  ConstValue.companyList;
//				//mCList.add(result);
////				ConstValue.companyList.clear();
////				ConstValue.companyList.add(result);
////				ArrayList<HashMap<String, String>> mList = result.get(ConstValue.SELECTED_MAINCATEGORY_ID);
////				setCatList(mList);
//				
//				setRefreshData();
//				
//			}
//
//			@Override
//			protected void onPreExecute() {
//				// TODO Auto-generated method stub
//				if (Util.isNetworkAvailable(context1)) {
////					LoadingDialogBox("open");
//				} else {
//					cancel(true);
//				}
//			}
//	    	
//	    }
	 
	 
	 
	 public void setRefreshData()
		{
			mca.notifyDataSetChanged();
		}    
	
	//------------------ADAPTER FOR COMPANY----------------//
    public class companyListAdapter extends BaseAdapter{
    	Context act;
    	private LayoutInflater inflater=null;
    	ArrayList<HashMap<String, String>> data;
    	ImageLazyLoader imgloader;
    	public companyListAdapter(Context a,ArrayList<HashMap<String, String>> maincat){
    		act = a;
    		data = maincat;
    		imgloader =  new ImageLazyLoader(act1);
    		inflater = (LayoutInflater)act1.getSystemService(Context.LAYOUT_INFLATER_SERVICE);
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
			        imgloader.DisplayImage(map.get("image"), act1, imgView);
			        else
			        	imgView.setImageResource(R.drawable.no_logo);		        
		        return vi;
		}
		
    }
    public void LoadFromDatabase(Cursor crd)
	{
		ConstValue.compList2.clear();

		Log.d("load company from database where `category`='"+ConstValue.SELECTED_MAINCATEGORY_ID+"'", "");
		if(crd.moveToFirst())
		{
			do {
				HashMap<String, String> map = new HashMap<String, String>();
				
				map.put("id",cr.getString(0));
				map.put("category",cr.getString(1));
				map.put("company",cr.getString(2));
				map.put("address",cr.getString(3));
				
				map.put("city",cr.getString(4));
				map.put("state",cr.getString(5));
				map.put("zip",cr.getString(6));
				
				map.put("website",cr.getString(7));
				map.put("fax",cr.getString(8));
				map.put("phone1",cr.getString(9));
				
				map.put("phone2",cr.getString(10));
				map.put("key_person1",cr.getString(11));
				map.put("key_person2",cr.getString(12));
				
				map.put("email1",cr.getString(13));
				map.put("email2",cr.getString(14));
				map.put("longitude",cr.getString(15));
				
				map.put("latitude",cr.getString(16));
				map.put("android",cr.getString(17));
				map.put("iphone",cr.getString(18));
				
				map.put("content",cr.getString(19));
				map.put("image",ConstValue.CONTENTS_IMAGE+"small/"+cr.getString(20));
				map.put("banner",ConstValue.CONTENTS_IMAGE+"big/"+cr.getString(21));
				map.put("status",cr.getString(22));
				
				map.put("order",cr.getString(23));
				map.put("special",cr.getString(24));
				map.put("top",cr.getString(25));
				
				ConstValue.compList2.add(map);
				
			} while (crd.moveToNext());
		}
		else
		{
			//Toast.makeText(context1, "No Company found", Toast.LENGTH_LONG).show();
			
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
			intent.putExtra("company_detail", ConstValue.compList2.get(position));
			startActivity(intent);
		}
	 @Override
		public void onDestroyView() {
			// TODO Auto-generated method stub
			db.close();
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
	
}
