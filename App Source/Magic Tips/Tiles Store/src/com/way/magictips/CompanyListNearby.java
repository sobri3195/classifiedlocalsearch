package com.way.magictips;

import java.io.File;
import java.io.IOException;
import java.util.ArrayList;
import java.util.HashMap;

import json.JSONParser;

import org.json.JSONArray;
import org.json.JSONObject;




import com.nostra13.universalimageloader.core.DisplayImageOptions;
import com.nostra13.universalimageloader.core.ImageLoader;
import com.nostra13.universalimageloader.core.ImageLoaderConfiguration;
import com.nostra13.universalimageloader.core.assist.ImageScaleType;
import com.nostra13.universalimageloader.core.display.SimpleBitmapDisplayer;
import com.nostra13.universalimageloader.core.listener.ImageLoadingListener;
import com.nostra13.universalimageloader.utils.StorageUtils;
import com.way.magictrik.R;













import defaultconfig.ConstValue;
import framework.ConnectionDetector;
import framework.GPSTracker;
import framework.ObjectSerializer;
import android.R.string;
import android.app.Activity;
import android.app.AlertDialog;
import android.content.Context;
import android.content.Intent;
import android.content.SharedPreferences;
import android.graphics.PointF;
import android.os.AsyncTask;
import android.os.Bundle;
import android.support.v4.app.Fragment;
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
import framework.GPSTracker;
public class CompanyListNearby extends Fragment implements OnItemClickListener,OnClickListener{

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
	
	
	static double EarthRadius = 6371000; // m
	static Double curLat,curLog;
	// Internet detector
		final String PREFS_NAME = "MyPrefsFile";
		SharedPreferences settings;
		ArrayList<HashMap<String, String>> compList = new ArrayList<HashMap<String,String>>();
		
		private ImageLoadingListener animateFirstListener = new AnimateFirstDisplayListener();
		DisplayImageOptions options;
		ImageLoaderConfiguration imgconfig; 
		
	public static Fragment newInstance(Context context,Activity asAct, Double lat, Double lon) {
		CompanyListNearby f = new CompanyListNearby();	
		context1=context;
		act1=asAct;
		curLat = lat;
		curLog = lon;
		
		return f;
	}
	@Override
	public View onCreateView(LayoutInflater inflater, ViewGroup container,Bundle savedInstanceState) {
		ViewGroup root = (ViewGroup) inflater.inflate(R.layout.company_list_2, null);	
		
		
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
    			compList = (ArrayList<HashMap<String,String>>) ObjectSerializer.deserialize(settings.getString(ConstValue.PREF_COMPANYIES+"near"+ConstValue.sel_category.get("id"), ObjectSerializer.serialize(new ArrayList<HashMap<String,String>>())));		
    		}catch (IOException e) {
    			    e.printStackTrace();
    		}
    		
    	
            lst3=(ListView)root.findViewById(R.id.listView1);
    		
   		 cd = new ConnectionDetector(context1);
   		 
   			
   		
   			
   		    
		mca = new companyListAdapter(context1, compList);
		lst3.setAdapter(mca);
		lst3.setOnItemClickListener(this);
		
		 cd = new ConnectionDetector(context1);
		 new MainMenuTask().execute(true);
	         
			
		
		return root;
	}
	//------------------ADAPTER FOR COMPANY----------------//
    public class companyListAdapter extends BaseAdapter{
    	Context act;
    	private LayoutInflater inflater=null;
    	ArrayList<HashMap<String, String>> data;
    	public companyListAdapter(Context a,ArrayList<HashMap<String, String>> maincat){
    		act = a;
    		data = maincat;
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
		        	ImageLoader.getInstance().displayImage(map.get("image"), imgView, options, animateFirstListener);
			        else
			        	imgView.setImageResource(R.drawable.no_logo);		        
		        return vi;
		}
		
    }
	public void onClick(View v) {
		// TODO Auto-generated method stub
		
	}

	public void onItemClick(AdapterView<?> parent, View view, int position,
			long id) {
		// TODO Auto-generated method stub
		Intent intent = new Intent(context1,CompanyDetails.class);
		ConstValue.sel_company = compList.get(position);
		startActivity(intent);
	}
	
	
	
	
	
	public static PointF calculateDerivedPosition(PointF point,
            double range, double bearing)
    {
        

        double latA = Math.toRadians(point.x);
        double lonA = Math.toRadians(point.y);
        double angularDistance = range / EarthRadius;
        double trueCourse = Math.toRadians(bearing);

        double lat = Math.asin(
                Math.sin(latA) * Math.cos(angularDistance) +
                        Math.cos(latA) * Math.sin(angularDistance)
                        * Math.cos(trueCourse));

        double dlon = Math.atan2(
                Math.sin(trueCourse) * Math.sin(angularDistance)
                        * Math.cos(latA),
                Math.cos(angularDistance) - Math.sin(latA) * Math.sin(lat));

        double lon = ((lonA + dlon + Math.PI) % (Math.PI * 2)) - Math.PI;

        lat = Math.toDegrees(lat);
        lon = Math.toDegrees(lon);

        PointF newPoint = new PointF((float) lat, (float) lon);

        return newPoint;

    }
	public String getWhereLocation(double lat,double log)
	{
		PointF center = new PointF((float)lat, (float)log);
		final double mult = 1; // mult = 1.1; is more reliable
		PointF p1 = calculateDerivedPosition(center, mult * EarthRadius, 0);
		PointF p2 = calculateDerivedPosition(center, mult * EarthRadius, 90);
		PointF p3 = calculateDerivedPosition(center, mult * EarthRadius, 180);
		PointF p4 = calculateDerivedPosition(center, mult * EarthRadius, 270);
		String COL_X = "latitude";
		String COL_Y = "longitude";
		return  " "
		        + COL_X + " > " + String.valueOf(p3.x) + " AND "
		        + COL_X + " < " + String.valueOf(p1.x) + " AND "
		        + COL_Y + " < " + String.valueOf(p2.y) + " AND "
		        + COL_Y + " > " + String.valueOf(p4.y);
	}
	public String getWhereLocation2(double lat,double log)
	{
		PointF center = new PointF((float)lat, (float)log);
		final double mult = 1; // mult = 1.1; is more reliable
		PointF p1 = calculateDerivedPosition(center, mult * EarthRadius, 0);
		PointF p2 = calculateDerivedPosition(center, mult * EarthRadius, 90);
		PointF p3 = calculateDerivedPosition(center, mult * EarthRadius, 180);
		PointF p4 = calculateDerivedPosition(center, mult * EarthRadius, 270);
		return  "&colx1="
		        + String.valueOf(p3.x) + "&colx2="
		        + String.valueOf(p1.x) + "&coly1="
		        + String.valueOf(p2.y) + "&coly2="
		        + String.valueOf(p4.y);
	}
	public static boolean pointIsInCircle(PointF pointForCheck, PointF center,
            double radius) {
        if (getDistanceBetweenTwoPoints(pointForCheck, center) <= radius)
            return true;
        else
            return false;
    }

	public static double getDistanceBetweenTwoPoints(PointF p1, PointF p2) {
        double R = EarthRadius; // m
        double dLat = Math.toRadians(p2.x - p1.x);
        double dLon = Math.toRadians(p2.y - p1.y);
        double lat1 = Math.toRadians(p1.x);
        double lat2 = Math.toRadians(p2.x);

        double a = Math.sin(dLat / 2) * Math.sin(dLat / 2) + Math.sin(dLon / 2)
                * Math.sin(dLon / 2) * Math.cos(lat1) * Math.cos(lat2);
        double c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1 - a));
        double d = R * c;

        return d;
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
						settings.edit().putString(ConstValue.PREF_COMPANYIES+"near"+ConstValue.sel_category.get("id"),ObjectSerializer.serialize(compList)).commit();
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
						
							//json = jParser.getJSONFromUrl(ConstValue.JSON_COMPANI_NEAR_BY+"?cat="+ConstValue.sel_category.get("id")+"&colx1="+String.valueOf(p3.x)+"&colx2="+String.valueOf(p1.x)+"&coly1="+String.valueOf(p2.x)+"&coly2="+String.valueOf(p4.x));
						
						json = jParser.getJSONFromUrl(ConstValue.JSON_COMPANI_NEAR_BY+"&cat="+ConstValue.sel_category.get("id")+"&lat="+curLat+"&lon="+curLog+"&rad=20");
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
