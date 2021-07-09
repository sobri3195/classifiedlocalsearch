package com.way.magictips;

import java.io.IOException;
import java.io.UnsupportedEncodingException;
import java.util.ArrayList;
import java.util.HashMap;
import java.util.List;

import json.JSONParser;

import org.apache.http.HttpResponse;
import org.apache.http.NameValuePair;
import org.apache.http.client.ClientProtocolException;
import org.apache.http.client.HttpClient;
import org.apache.http.client.entity.UrlEncodedFormEntity;
import org.apache.http.client.methods.HttpPost;
import org.apache.http.impl.client.DefaultHttpClient;
import org.apache.http.message.BasicNameValuePair;
import org.apache.http.util.EntityUtils;
import org.json.JSONArray;
import org.json.JSONObject;

import util.common.Util;
import util.imageLoader.ImageLazyLoader;

import com.way.magictrik.R;

import defaultconfig.ConstValue;
import framework.ConnectionDetector;
import framework.ObjectSerializer;
import android.annotation.SuppressLint;
import android.annotation.TargetApi;
import android.app.Activity;
import android.content.Context;
import android.content.SharedPreferences;
import android.database.Cursor;
import android.database.sqlite.SQLiteDatabase;
import android.os.AsyncTask;
import android.os.Build;
import android.os.Bundle;
import android.os.StrictMode;
import android.util.Log;
import android.view.LayoutInflater;
import android.view.Menu;
import android.view.MenuItem;
import android.view.View;
import android.view.View.OnClickListener;
import android.view.ViewGroup;
import android.widget.AdapterView;
import android.widget.ArrayAdapter;
import android.widget.BaseAdapter;
import android.widget.Button;
import android.widget.CheckBox;
import android.widget.ListView;
import android.widget.Spinner;
import android.widget.AdapterView.OnItemSelectedListener;
import android.widget.Toast;

public class AddPost3 extends Activity {
	ArrayList<String> items;
	ArrayList<Integer> ids;
	ArrayList<HashMap<String, String>> compList = new ArrayList<HashMap<String,String>>();
	View progressBar;
	companyListAdapter mca;
	ListView lst;
	ConnectionDetector cd;
	int SelectedCategory ;
	String[] selected;
	ArrayList<InfoRowdata> infodata;
	String company,email,web,city,state,zip,phone,address;
	final String PREFS_NAME = "MyPrefsFile";
	SharedPreferences settings;
	@TargetApi(Build.VERSION_CODES.GINGERBREAD) @SuppressLint("NewApi") @Override
	protected void onCreate(Bundle savedInstanceState) {
		super.onCreate(savedInstanceState);
		setContentView(R.layout.add_post3);
		settings = getSharedPreferences(PREFS_NAME, 0);
		
		Bundle b = getIntent().getExtras();
		company = b.getString("company");
		email = b.getString("email");
		web = b.getString("web");
		
		city = b.getString("city");
		state = b.getString("state");
		zip = b.getString("zip");
		phone = b.getString("phone");
		address = b.getString("address");
		
		 if (android.os.Build.VERSION.SDK_INT > 9) {
			    StrictMode.ThreadPolicy policy = new StrictMode.ThreadPolicy.Builder().permitAll().build();
			    StrictMode.setThreadPolicy(policy);
			}
		
		progressBar = (View)findViewById(R.id.progressBarView);
		progressBar.setVisibility(View.GONE);
		
		
		items = new ArrayList<String>();
		ids = new ArrayList<Integer>();
		
		lst = (ListView)findViewById(R.id.listView1);
		
		mca =new companyListAdapter(getApplicationContext(), compList,this);
		lst.setAdapter(mca);
		
		ArrayList<HashMap<String, String>> maincats = new ArrayList<HashMap<String,String>>();
		try {
			maincats = (ArrayList<HashMap<String,String>>) ObjectSerializer.deserialize(settings.getString(ConstValue.PREF_MAINMENU, ObjectSerializer.serialize(new ArrayList<HashMap<String,String>>())));		
		}catch (IOException e) {
			    e.printStackTrace();
		}
		for (int i = 0; i < maincats.size(); i++) {
			HashMap<String, String> map = new HashMap<String, String>();
			map = maincats.get(i);
			items.add(map.get("title"));
			ids.add(Integer.parseInt(map.get("id")));
		}
		
		Spinner spin =(Spinner)findViewById(R.id.spinner1);
		ArrayAdapter<String> arr = new ArrayAdapter<String>(this, android.R.layout.simple_spinner_item,items);
		arr.setDropDownViewResource( android.R.layout.simple_spinner_dropdown_item);
				spin.setAdapter(arr);
				
				spin.setOnItemSelectedListener(new OnItemSelectedListener() {

					public void onItemSelected(AdapterView<?> parent,
							View view, int position, long id) {
						// TODO Auto-generated method stub
						SelectedCategory = ids.get(position);
						infodata = new ArrayList<InfoRowdata>();
						LoadDataInBackground();
					}

					public void onNothingSelected(AdapterView<?> parent) {
						// TODO Auto-generated method stub
						
					}

				});
				
					
				
	
		
		
		Button btn = (Button)findViewById(R.id.button2);
		btn.setOnClickListener(new OnClickListener() {
			
			public void onClick(View v) {
				// TODO Auto-generated method stub
				if(infodata.size()>0)
				{
					HttpClient httpclient = new DefaultHttpClient();
		    	    HttpPost httppost = new HttpPost(ConstValue.JSON_REGISTRATION_ADD);
		    	    List<NameValuePair> nameValuePairs = new ArrayList<NameValuePair>(2);
	    	        
				 for(int i=0;i<infodata.size();i++)
                 {
                     if (infodata.get(i).isclicked)
                     {
                    	 nameValuePairs.add(new BasicNameValuePair("category[]", infodata.get(i).catId ));
                     }
                 }
				 	nameValuePairs.add(new BasicNameValuePair("name", company));
	    	        nameValuePairs.add(new BasicNameValuePair("address", address));
	    	        nameValuePairs.add(new BasicNameValuePair("email1", email));
	    	        nameValuePairs.add(new BasicNameValuePair("phone1", phone));
	    	        nameValuePairs.add(new BasicNameValuePair("city", city));
	    	        nameValuePairs.add(new BasicNameValuePair("state", state));
	    	        nameValuePairs.add(new BasicNameValuePair("website", web));
	    	        nameValuePairs.add(new BasicNameValuePair("zip", zip));
	    	        nameValuePairs.add(new BasicNameValuePair("fax", ""));
	    	        
	    	        nameValuePairs.add(new BasicNameValuePair("add", "add"));
	    	        
	    	        
	    	        try {
						httppost.setEntity(new UrlEncodedFormEntity(nameValuePairs));
						// Execute HTTP Post Request
		    	        HttpResponse response = httpclient.execute(httppost);
		    	        
		    	        if(response.getEntity()!=null)
		    	        {
		    	        	String responseText= EntityUtils.toString(response.getEntity());
		    	        	//if(responseText=="success"){
		    	        		Toast.makeText(AddPost3.this,"Review Added Successfully."+responseText, Toast.LENGTH_LONG).show();
		    	        		finish();
		    	        	//}
		    	        	//else
		    	        	//	Toast.makeText(AddPost3.this,"Error :."+responseText, Toast.LENGTH_LONG).show();
		    	        }
		    	        else
		    	        {
		    	        	Toast.makeText(AddPost3.this,"Fail. Could Not Connect To Server.", Toast.LENGTH_LONG).show();
		    	        	
		    	        }
					} catch (UnsupportedEncodingException e) {
						// TODO Auto-generated catch block
						e.printStackTrace();
					} catch (ClientProtocolException e) {
						// TODO Auto-generated catch block
						e.printStackTrace();
					} catch (IOException e) {
						// TODO Auto-generated catch block
						e.printStackTrace();
					}

	     	       
	    	        
	    	        
				}
			}
		});

				
	}
	
	public void LoadDataInBackground()
	{
		cd = new ConnectionDetector(this.getApplicationContext());
		// Check if Internet present
		if (!cd.isConnectingToInternet()) {
			// Internet Connection is not present
			//new CompanyOffLine().execute();
		}else{
			progressBar.setVisibility(View.VISIBLE);
			new companyListAsyTask().execute();
		}	
	}
	
	public class InfoRowdata {

	    public boolean isclicked=false;
	    public int index;
	    public String catId;
	    /*public String fanId;
	    public String strAmount;*/

	    public InfoRowdata(boolean isclicked,int index,String catId/*,String fanId,String strAmount*/)
	    {
	        this.index=index;
	        this.isclicked=isclicked;
	        this.catId = catId;
	        /*this.fanId=fanId;
	        this.strAmount=strAmount;*/
	    }

}
	
	public class companyListAsyTask extends AsyncTask<Boolean, Void, ArrayList<HashMap<String, String>>> {

		JSONParser jParser;
		JSONObject json;
		
		@Override
		protected void onPreExecute() {
			// TODO Auto-generated method stub
			super.onPreExecute();
		}

		@Override
		protected void onPostExecute(ArrayList<HashMap<String, String>> result) {
			// TODO Auto-generated method stub
			if (result!=null) {
				
				//adapter.notifyDataSetChanged();
			}
			
			try {
				settings.edit().putString(ConstValue.PREF_CATEGORIES+SelectedCategory,ObjectSerializer.serialize(compList)).commit();
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
					
					progressBar.setVisibility(View.VISIBLE);
					json = jParser.getJSONFromUrl(ConstValue.JSON_CAT+SelectedCategory);
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

		public View getView(final int position, View convertView, ViewGroup parent) {
			// TODO Auto-generated method stub
			 View vi=convertView;
		        if(convertView==null)
		            vi = inflater.inflate(R.layout.row_category_2, null);
	        
		        
		        
		        HashMap<String, String> map = new HashMap<String, String>();
		        map = data.get(position);
		        infodata.add(new InfoRowdata(false, position,map.get("id")));
		        
		        String title = map.get("title");
		        if(map.get("title").length()>15)
		        {
		        	title = map.get("title").substring(0, 14) + "..";
		        }
		        String upperString = title.substring(0,1).toUpperCase() + title.substring(1).toLowerCase();
		        
		        final String id = map.get("id");
		        
		        final CheckBox cb = (CheckBox) vi
	                    .findViewById(R.id.checkBox1);
		        cb.setText(upperString);
	            cb.setOnClickListener(new OnClickListener() {

					public void onClick(View v) {
						// TODO Auto-generated method stub
//						if(cb.isChecked())
//						{
//							selected[position] = id;
//							Toast.makeText(act,"Is checked :"+cb.isChecked()+" : "+id, Toast.LENGTH_LONG).show(); 
//						}else
//						{
//							
//						}
						Toast.makeText(act,"Is checked :"+cb.isChecked()+" : "+id, Toast.LENGTH_LONG).show();
						if (infodata.get(position).isclicked) {
                            infodata.get(position).isclicked = false;
                        } else {
                            infodata.get(position).isclicked = true;
                        }
						
						
                   // for(int i=0;i<infodata.size();i++)
                   // {
                   //     if (infodata.get(i).isclicked)
                   //     {
                            //System.out.println("Selectes Are == "+ data[i]);
                   //     }
                   // }
					}
	            });
	            	           
		        return vi;
		}
		
 }

	
	@Override
	public boolean onCreateOptionsMenu(Menu menu) {
		// Inflate the menu; this adds items to the action bar if it is present.
		getMenuInflater().inflate(R.menu.add_post3, menu);
		return true;
	}

	@Override
	public boolean onOptionsItemSelected(MenuItem item) {
		// Handle action bar item clicks here. The action bar will
		// automatically handle clicks on the Home/Up button, so long
		// as you specify a parent activity in AndroidManifest.xml.
		int id = item.getItemId();
		if (id == R.id.action_settings) {
			return true;
		}
		return super.onOptionsItemSelected(item);
	}
	
	
}
