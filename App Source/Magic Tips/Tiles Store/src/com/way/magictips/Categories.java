package com.way.magictips;

import java.io.IOException;
import java.util.ArrayList;
import java.util.HashMap;

import json.JSONParser;

import org.json.JSONArray;
import org.json.JSONObject;

import util.common.Util;
import util.imageLoader.ImageLazyLoader;

import com.google.android.gms.ads.AdRequest;
import com.google.android.gms.ads.AdView;
import com.way.magictrik.R;

import dbHelper.SqlDbHelper;
import defaultconfig.ConstValue;
import framework.ConnectionDetector;
import framework.ObjectSerializer;
import android.support.v4.app.FragmentActivity;
import android.annotation.TargetApi;
import android.app.Activity;
import android.content.Context;
import android.content.Intent;
import android.content.SharedPreferences;
import android.database.Cursor;
import android.database.sqlite.SQLiteDatabase;
import android.database.sqlite.SQLiteDatabaseLockedException;
import android.os.AsyncTask;
import android.os.Build;
import android.os.Bundle;
import android.util.Log;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.view.Window;
import android.view.View.OnClickListener;
import android.widget.AdapterView;
import android.widget.BaseAdapter;
import android.widget.Button;
import android.widget.ListView;
import android.widget.TextView;
import android.widget.Toast;
import android.widget.AdapterView.OnItemClickListener;

@TargetApi(Build.VERSION_CODES.HONEYCOMB)
public class Categories extends FragmentActivity implements OnItemClickListener,OnClickListener{
	static Context context1;
	static Activity act1;
	companyListAdapter mca;
	ListView lst3;
//	ProgressDialog barProgressDialog;
	//	AlertDialog.Builder loadingBuilder;
//	AlertDialog loadingDialog;
	ConnectionDetector cd;
	Button btnBack,btnHome;
	TextView txtTitle;
	ArrayList<HashMap<String, String>> compList = new ArrayList<HashMap<String,String>>();
	
	View progressBar;
	final String PREFS_NAME = "MyPrefsFile";
	SharedPreferences settings;
	
	protected void onCreate(Bundle savedInstanceState) {
		super.onCreate(savedInstanceState);
		requestWindowFeature(Window.FEATURE_NO_TITLE);
		setContentView(R.layout.categories);
		settings = getSharedPreferences(PREFS_NAME, 0);
		cd = new ConnectionDetector(getApplicationContext());
			
		progressBar = (View)findViewById(R.id.progressBarView);
		progressBar.setVisibility(View.GONE);
		
		 // Look up the AdView as a resource and load a request.
		AdView mAdView = (AdView) findViewById(R.id.adView);
        AdRequest adRequest = new AdRequest.Builder().build();
        mAdView.loadAd(adRequest);
       // adView.loadAd(new AdRequest());
        try {
			compList = (ArrayList<HashMap<String,String>>) ObjectSerializer.deserialize(settings.getString(ConstValue.PREF_CATEGORIES+ConstValue.sel_main_category.get("id"), ObjectSerializer.serialize(new ArrayList<HashMap<String,String>>())));		
		}catch (IOException e) {
			    e.printStackTrace();
		}
        
    		
		context1=this.getApplicationContext();
		act1=this;
		lst3=(ListView)findViewById(R.id.listView1);
		lst3.bringToFront();
	
		mca =new companyListAdapter(context1,compList,act1);
		lst3.setAdapter(mca);
		lst3.setOnItemClickListener(this);
		
		
		btnBack = (Button)findViewById(R.id.button1);
		btnBack.setOnClickListener(this);
		
		btnHome = (Button)findViewById(R.id.btnback);
		btnHome.setOnClickListener(this);
		
		new MainMenuTask().execute(true);
//			barProgressDialog = new ProgressDialog(Categories.this);
			 
//				        barProgressDialog.setTitle("Loading ...");
//				        barProgressDialog.setMessage("Connect to server progress ...");
//				        barProgressDialog.show();
		
		txtTitle = (TextView)findViewById(R.id.textView1);
		txtTitle.setText(ConstValue.SELECTED_CATEGORY_TITLE);
	}

	


	     
	public void setRefreshData()
	{
		mca.notifyDataSetChanged();
	}
	public class MainMenuTask extends AsyncTask<Boolean, Void, ArrayList<HashMap<String, String>>> {

		JSONParser jParser;
		JSONObject json;
		
		@Override
		protected void onPreExecute() {
			// TODO Auto-generated method stub
			progressBar.setVisibility(View.VISIBLE);
			super.onPreExecute();
		}

		@Override
		protected void onPostExecute(ArrayList<HashMap<String, String>> result) {
			// TODO Auto-generated method stub
			if (result!=null) {
				
				//adapter.notifyDataSetChanged();
			}
			
			try {
				settings.edit().putString(ConstValue.PREF_CATEGORIES+ConstValue.sel_main_category.get("id"),ObjectSerializer.serialize(compList)).commit();
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
					
					
					json = jParser.getJSONFromUrl(ConstValue.JSON_CAT+ConstValue.sel_main_category.get("id"));
					JSONArray menus = json.getJSONArray("categories");
					if(menus!=null)
					{
						compList.clear();
						for (int i = 0; i < menus.length(); i++) {
							JSONObject c = menus.getJSONObject(i);
							HashMap<String, String> map = new HashMap<String, String>();
							map.put("id", c.getString("id"));
							map.put("parent", c.getString("parent"));
							map.put("title", c.getString("title"));
							map.put("description", c.getString("description"));
							map.put("icon", c.getString("icon"));
							compList.add(map);
						}
						
					}
					
				}else
				{
					Toast.makeText(getApplicationContext(), "Please connect mobile with working Internet", Toast.LENGTH_LONG).show();
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
	//------------------ADAPTER FOR COMPANY----------------//
    public class companyListAdapter extends BaseAdapter{
    	Context act;
    	private LayoutInflater inflater=null;
    	ArrayList<HashMap<String, String>> data;
    	ImageLazyLoader imgloader;
    	public companyListAdapter(Context a,ArrayList<HashMap<String, String>> maincat,Activity ac1){
    		act = a;
    		
    		data = maincat;
    		imgloader=new ImageLazyLoader(ac1);
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
		            vi = inflater.inflate(R.layout.row_category, null);
	        
		        HashMap<String, String> map = new HashMap<String, String>();
		        map = data.get(position);
		       TextView txt = (TextView)vi.findViewById(R.id.textTitle);
		        String title = map.get("title");
		        if(map.get("title").length()>15)
		        {
		        	title = map.get("title").substring(0, 14) + "..";
		        }
		        String upperString = title.substring(0,1).toUpperCase() + title.substring(1).toLowerCase();
		        txt.setText(upperString);
		        
		        
		        return vi;
		}
		
    }
   
	public void onClick(View v) {
		// TODO Auto-generated method stub
		switch (v.getId()) {
		case R.id.button1:
			
			finish();
			overridePendingTransition(R.anim.animation_enter,R.anim.animation_leave);
			break;
		case R.id.btnback:
			finish();
			break;
		default:
			break;
		}
	}

	 public void onItemClick(AdapterView<?> parent, View view, int position, long id) {
			// TODO Auto-generated method stub
		 Log.d("parent", ""+parent);
		// ConstValue.SELECTED_COMPANY_ID = Integer.parseInt(compList.get(position).get("id"));
		 HashMap<String, String> map = new HashMap<String, String>();
	        map = compList.get(position);
		 ConstValue.sel_category = map;
	        //ConstValue.SELECTED_MAINCATEGORY_ID = map.get("id");
		 //ConstValue.SELECTED_MAINCATEGORY_TITLE = map.get("title");
			Intent intent = new Intent(context1,CompanyMain.class);
			startActivity(intent);
		}
	 
	 @Override
		protected void onDestroy() {
			// TODO Auto-generated method stub
			super.onDestroy();
		}
		
		
}
