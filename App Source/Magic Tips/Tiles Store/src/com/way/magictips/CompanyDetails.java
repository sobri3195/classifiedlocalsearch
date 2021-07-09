package com.way.magictips;

import java.io.File;
import java.io.FileNotFoundException;
import java.io.IOException;
import java.io.InputStream;
import java.net.MalformedURLException;
import java.net.URL;
import java.util.ArrayList;
import java.util.Collections;
import java.util.HashMap;
import java.util.LinkedList;
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

import com.androidquery.AQuery;
import com.google.android.gms.ads.AdRequest;
import com.google.android.gms.ads.AdView;
import com.nostra13.universalimageloader.core.DisplayImageOptions;
import com.nostra13.universalimageloader.core.ImageLoader;
import com.nostra13.universalimageloader.core.ImageLoaderConfiguration;
import com.nostra13.universalimageloader.core.assist.ImageScaleType;
import com.nostra13.universalimageloader.core.display.FadeInBitmapDisplayer;
import com.nostra13.universalimageloader.core.display.RoundedBitmapDisplayer;
import com.nostra13.universalimageloader.core.display.SimpleBitmapDisplayer;
import com.nostra13.universalimageloader.core.listener.ImageLoadingListener;
import com.nostra13.universalimageloader.core.listener.SimpleImageLoadingListener;
import com.nostra13.universalimageloader.utils.StorageUtils;
import com.way.magictips.HomeActiviry.AnimateFirstDisplayListener;
import com.way.magictrik.R;

import defaultconfig.ConstValue;
import framework.BaseActivity;
import framework.ConnectionDetector;
import framework.ObjectSerializer;
import android.net.Uri;
import android.os.AsyncTask;
import android.os.Build;
import android.os.Bundle;
import android.os.StrictMode;
import android.annotation.SuppressLint;
import android.annotation.TargetApi;
import android.app.AlertDialog;
import android.app.ProgressDialog;
import android.content.Context;
import android.content.Intent;
import android.content.SharedPreferences;
import android.database.Cursor;
import android.database.sqlite.SQLiteDatabase;
import android.graphics.Bitmap;
import android.graphics.BitmapFactory;
import android.graphics.Color;
import android.graphics.drawable.BitmapDrawable;
import android.graphics.drawable.Drawable;
import android.graphics.drawable.LevelListDrawable;
import android.text.Html;
import android.text.Html.ImageGetter;
import android.text.Spanned;
import android.text.util.Linkify;
import android.util.Log;
import android.view.Gravity;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.view.View.OnClickListener;
import android.view.Window;
import android.widget.BaseAdapter;
import android.widget.Button;
import android.widget.ImageView;
import android.widget.LinearLayout;
import android.widget.ListAdapter;
import android.widget.ListView;
import android.widget.PopupWindow;
import android.widget.RatingBar;
import android.widget.RelativeLayout;
import android.widget.TextView;
import android.widget.Toast;
import util.imageLoader.ImageLazyLoader;
import util.imageLoader.ImageLazyLoader.Quality;
@SuppressLint("NewApi") public class CompanyDetails extends BaseActivity implements OnClickListener,ImageGetter {
	ArrayList<HashMap<String, String>> mCompanyList;
	HashMap<String, String> companyMap;
	AQuery aq;
	String linkPlayStore,linkAppStore,website,stringmapLocation;
	ImageView imgthumb,imginquiry,imglocation,imgweb;
//	ImageLazyLoader imgloader;
	TextView txtphone,txtemail;
	AlertDialog.Builder loadingBuilder;
	AlertDialog loadingDialog;
	
	private PopupWindow pwindo;
	Button btnClosePopup;
	Button btnCreatePopup;
	Button btnHome;
	
	private final static String TAG = "TestImageGetter";
    private TextView mTv;
    
	// Internet detector
	ConnectionDetector cd;
	
	LinearLayout linearreviewhead;
	//ArrayList<HashMap<String, String>> compList = new ArrayList<HashMap<String,String>>();
	ArrayList<HashMap<String, String>> reviewList = new ArrayList<HashMap<String,String>>();
	LinearLayout lin1,lin2;
	
	
	
	final String PREFS_NAME = "MyPrefsFile";
	SharedPreferences settings;
	
	reviewListAdapter reviewadapter;
	
	private ImageLoadingListener animateFirstListener = new AnimateFirstDisplayListener();
	DisplayImageOptions options;
	ImageLoaderConfiguration imgconfig; 
	
	
    @TargetApi(Build.VERSION_CODES.GINGERBREAD) @SuppressLint("NewApi") @Override
    public void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.company_details);
        settings = this.getSharedPreferences(PREFS_NAME, 0);
		
        File cacheDir = StorageUtils.getCacheDirectory(getApplicationContext());
		
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
		
		imgconfig = new ImageLoaderConfiguration.Builder(getApplicationContext())
		.build();
		ImageLoader.getInstance().init(imgconfig);
        
        if (android.os.Build.VERSION.SDK_INT > 9) {
		    StrictMode.ThreadPolicy policy = new StrictMode.ThreadPolicy.Builder().permitAll().build();
		    StrictMode.setThreadPolicy(policy);
		}
        
        
     // Look up the AdView as a resource and load a request.
        /*AdView adView = (AdView)this.findViewById(R.id.adView);
        
        AdRequest adRequest = new AdRequest.Builder()
        .addTestDevice(AdRequest.DEVICE_ID_EMULATOR)
        .addTestDevice("TEST_DEVICE_ID")
        .build();
        adView.loadAd(adRequest);*/
        
        AdView mAdView = (AdView)findViewById(R.id.adView);
        AdRequest adRequest = new AdRequest.Builder().build();
        mAdView.loadAd(adRequest);
        
        linearreviewhead=(LinearLayout)findViewById(R.id.reviewparent);
        
		
        btnCreatePopup = (Button) findViewById(R.id.btnreview);
        btnCreatePopup.setOnClickListener(this);
        
        btnHome = (Button) findViewById(R.id.button1);
        btnHome.setOnClickListener(this);
		 cd = new ConnectionDetector(this);

			// Check if Internet present
        
        lin1=(LinearLayout)findViewById(R.id.linear1);
        lin2=(LinearLayout)findViewById(R.id.linear2);
        
      
        
        Button btnback=(Button)findViewById(R.id.btnback);
        btnback.setOnClickListener(this);
        ImageView playstore=(ImageView)findViewById(R.id.buttonPlayStore);
        playstore.setOnClickListener(this);
        ImageView appstore=(ImageView)findViewById(R.id.ButtonAppstore);
        appstore.setOnClickListener(this);
        
        
        TextView txtemail=(TextView)findViewById(R.id.textView2);
        txtemail.setOnClickListener(this);

        TextView txtlocation=(TextView)findViewById(R.id.textView3);
        
        txtlocation.setOnClickListener(this);

        TextView txtweb=(TextView)findViewById(R.id.textView4);
        txtweb.setOnClickListener(this);
       imgthumb=(ImageView)findViewById(R.id.img_thumb);
       imginquiry=(ImageView)findViewById(R.id.imageView2);
       imglocation=(ImageView)findViewById(R.id.imageView3);
       imgweb=(ImageView)findViewById(R.id.imageView4);
       
       imginquiry.setOnClickListener(this);
       imglocation.setOnClickListener(this);
       imgweb.setOnClickListener(this);
       
       txtphone=(TextView)findViewById(R.id.textPhone);
       txtphone.setOnClickListener(this);
       
       txtemail=(TextView)findViewById(R.id.textEmail);
       txtemail.setOnClickListener(this);
       
       
        
//       imgloader =  new ImageLazyLoader(this,Quality.HIGH);
        
        
        aq =new AQuery(this);
    			
    			companyMap = ConstValue.sel_company; //(HashMap<String, String>) getIntent().getSerializableExtra("company_detail");
    			String title = companyMap.get("company");
    			setHeaderTitle(title);
    			
    			aq.id(R.id.txttitle).text(title).visible();
    			//String imgpath =ConstValue.CONTENTS_IMAGE+"small/"+companyMap.get("image");
    			//aq.id(R.id.imageLogo).image(companyMap.get("image"), true, true, 0, AQuery.GONE);
    			aq.id(R.id.textAddress).text(companyMap.get("address")).visible();
    			if(!companyMap.get("phone1").equals(""))
    			{
    				aq.id(R.id.linearcell).visibility(View.VISIBLE);
    				aq.id(R.id.textPhone).text(companyMap.get("phone1")).visible();
    				aq.id(R.id.cellline).visibility(View.VISIBLE);
    			}
    			if(!companyMap.get("fax").equals(""))
    			{
    				aq.id(R.id.linearfax).visibility(View.VISIBLE);
    				aq.id(R.id.textFax).text(companyMap.get("fax")).visible();
    				aq.id(R.id.faxline).visibility(View.VISIBLE);
    			}
    				
    			if(!companyMap.get("email1").equals(""))
    			{
    				aq.id(R.id.linearemail).visibility(View.VISIBLE);
    				aq.id(R.id.textEmail).text(companyMap.get("email1")).visible();
    				aq.id(R.id.emailline).visibility(View.VISIBLE);
    			}
    			if(!companyMap.get("key_person1").equals(""))
    			{
    				aq.id(R.id.TextView04).visibility(View.VISIBLE);
    				aq.id(R.id.layoutkey1).visibility(View.VISIBLE);
    				aq.id(R.id.TextView01).text(companyMap.get("key_person1")).visible();
    				aq.id(R.id.key1line).visibility(View.VISIBLE);
    			}
    			if(!companyMap.get("key_person2").equals(""))
    			{
    				aq.id(R.id.TextView04).visibility(View.VISIBLE);
    				aq.id(R.id.layoutkey2).visibility(View.VISIBLE);
    				aq.id(R.id.TextView02).text(companyMap.get("key_person2")).visible();
    				aq.id(R.id.key2line).visibility(View.VISIBLE);
    			
    			}
    			
    			if(companyMap.get("special").equals("1"))
    				aq.id(R.id.layoutgoldbtn).visibility(View.VISIBLE);
    			
    			Linkify.addLinks(txtphone, Linkify.PHONE_NUMBERS);
    			txtphone.setLinkTextColor(Color.BLACK);
    			
    			Linkify.addLinks(txtemail, Linkify.EMAIL_ADDRESSES);
    			txtemail.setLinkTextColor(Color.BLACK);
    			
    			
    			Log.d("app link", companyMap.get("iphone")+" : ;"+companyMap.get("android"));
    			if(companyMap.get("iphone").equals("")&&companyMap.get("android").equals(""))
    			{
    			LinearLayout rlstore=(LinearLayout)findViewById(R.id.layout_store);
    			rlstore.setVisibility(View.GONE);
    			}
    			else
    			{
    			if(companyMap.get("iphone").equals(""))
    			appstore.setVisibility(View.GONE);
    			if(companyMap.get("android").equals(""))
    			playstore.setVisibility(View.GONE);
    			}
    			linkAppStore = companyMap.get("iphone");
    			linkPlayStore = companyMap.get("android");
    			website=companyMap.get("website");
    			stringmapLocation= companyMap.get("map_location");
    		
    			if(cd.isConnectingToInternet())
    			{
       			 Spanned spanned = Html.fromHtml(companyMap.get("content"), this, null);
       		        mTv = (TextView) findViewById(R.id.textAbout);
       		        mTv.setText(spanned);
    			}
    			else
    			aq.id(R.id.textAbout).text((Html.fromHtml(companyMap.get("content")))).visible(); 
    			
    			if(companyMap.get("content").equals(""))
    	    	{
    	    		lin2.setVisibility(View.GONE);
    	    	}
    			if(!companyMap.get("banner").equals("")){
    				ImageLoader.getInstance().displayImage(ConstValue.CONTENTS_IMAGE+"big/"+companyMap.get("banner"), imgthumb, options, animateFirstListener);
    			}else{
    				imgthumb.setVisibility(View.GONE);
    			}

    			
    			try {
        			reviewList = (ArrayList<HashMap<String,String>>) ObjectSerializer.deserialize(settings.getString(ConstValue.PREF_REVIEW+ConstValue.sel_company.get("id"), ObjectSerializer.serialize(new ArrayList<HashMap<String,String>>())));		
        		}catch (IOException e) {
        			    e.printStackTrace();
        		}
    			
    			ListView listreview = (ListView)findViewById(R.id.listReview);
    			reviewadapter = new reviewListAdapter(getApplicationContext(), this.reviewList);
    			listreview.setAdapter(reviewadapter);
    			
    			new LoadReviewTask().execute(true);
    }

  
    
	public void onClick(View v) {
		// TODO Auto-generated method stub
		Intent intent = null;
		switch (v.getId()) {
		case R.id.btnback:
			finish();
			break;
		case R.id.button1:
			intent=new Intent(CompanyDetails.this,HomeActiviry.class);			
			overridePendingTransition(R.anim.animation_enter,R.anim.animation_leave);
			break;
		case R.id.buttonPlayStore:
			if(!linkPlayStore.equals(""))
			intent = new Intent(Intent.ACTION_VIEW, Uri.parse(linkPlayStore));
			break;
		case R.id.ButtonAppstore:
			if(!linkAppStore.equals(""))
			intent = new Intent(Intent.ACTION_VIEW, Uri.parse(linkAppStore));	
			break;
		case R.id.imageView4:
		case R.id.textView4:
			if(!companyMap.get("website").equals(""))
			intent = new Intent(Intent.ACTION_VIEW, Uri.parse("https://"+companyMap.get("website")));
			else
				Toast.makeText(this,"No Web Url Found", Toast.LENGTH_LONG).show();
			break;
		case R.id.imageView3:
		case R.id.textView3:
			if(!companyMap.get("latitude").equals("")||!companyMap.get("longitude").equals(""))
			{
			intent = new Intent(this, MapActivity.class);	
			//	intent = new Intent(this, ShowRoute.class);
			intent.putExtra("latitude", Double.parseDouble(companyMap.get("latitude")));
			intent.putExtra("longitude", Double.parseDouble(companyMap.get("longitude")));
			intent.putExtra("company", companyMap.get("company"));
			}else
			Toast.makeText(this,"No Location Found", Toast.LENGTH_LONG).show();
			break;
		case R.id.imageView2:
		case R.id.textView2:
			intent = new Intent(this, Inquiry.class);	
			intent.putExtra("company_detail", companyMap);
			break;
		case R.id.btnhome:
			Intent intent1=new Intent(CompanyDetails.this,HomeActiviry.class);
			startActivity(intent1);
			overridePendingTransition(R.anim.animation_enter,R.anim.animation_leave);
			break;
		case R.id.btnreview:
			  initiatePopupWindow();
			  break;
		default:
			break;
		}
		if(intent!=null)
			startActivity(intent);
	}
	
	
    
	
//	public void setCatList(ArrayList<HashMap<String, String>> mList)
//    {
//    	mca =new companyListAdapter(this,mList);
//        //aq.id(R.id.listView1).adapter(mca);
//    //	if(lst1.getAdapter()!=null)
	//    	lst3.addFooterView(inflater1.inflate(R.layout.review_row_footer, null));
//    
//    	lst3.setAdapter(mca);
//    //	updateListViewHeight(lst3);
//    //	lst3.setOnItemClickListener(this);
    
		
/*		LayoutInflater	inflater1 = (LayoutInflater)this.getSystemService(Context.LAYOUT_INFLATER_SERVICE);
		if(!mList.isEmpty())
		{
		for(int i=0;i<mList.size();i++)
		{
			View  vi = inflater1.inflate(R.layout.review_row, null);
			HashMap<String, String> map = new HashMap<String, String>();
	        map = mList.get(i);
	        TextView txt = (TextView)vi.findViewById(R.id.r_txtname);
	        
	        txt.setText(map.get("title"));
	        TextView txtmail = (TextView)vi.findViewById(R.id.r_txtemail);
	        txtmail.setText(map.get("email"));
	        
	        TextView txtreview = (TextView)vi.findViewById(R.id.r_txtreview);
	        txtreview.setText(map.get("review"));
	        
	        RatingBar rtb1=(RatingBar)vi.findViewById(R.id.r_ratingbar);
	        rtb1.setRating(Float.parseFloat(map.get("ratting")));
	        
	        linearreviewhead.addView(vi);
			}
		}
*/		
        
		
		
		
 //   }


	   public class reviewListAdapter extends BaseAdapter{
	    	Context act;
	    	private LayoutInflater inflater=null;
	    	ArrayList<HashMap<String, String>> data;
	    	ImageLazyLoader imgloader;
	    	public reviewListAdapter(Context a,ArrayList<HashMap<String, String>> maincat){
	    		act = a;
	    		data = maincat;
	    		inflater = (LayoutInflater)act.getSystemService(Context.LAYOUT_INFLATER_SERVICE);
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
			            vi = inflater.inflate(R.layout.review_row, null);
		        	
			        HashMap<String, String> map = new HashMap<String, String>();
			        map = reviewList.get(position);
			        TextView txt = (TextView)vi.findViewById(R.id.r_txtname);
			        
			        txt.setText(map.get("title"));
			        TextView txtmail = (TextView)vi.findViewById(R.id.r_txtemail);
			        txtmail.setText(map.get("email"));
			        
			        TextView txtreview = (TextView)vi.findViewById(R.id.r_txtreview);
			        txtreview.setText(map.get("review"));
			        
			        RatingBar rtb1=(RatingBar)vi.findViewById(R.id.r_ratingbar);
			        rtb1.setRating(Float.parseFloat(map.get("ratting")));
			        
			        
			        
			        return vi;
			}
			
	    }
    
    private void initiatePopupWindow() {
    	try {
    	// We need to get the instance of the LayoutInflater
    	LayoutInflater inflater = (LayoutInflater) CompanyDetails.this
    	.getSystemService(Context.LAYOUT_INFLATER_SERVICE);
    	View layout = inflater.inflate(R.layout.review_row_footer,
    	(ViewGroup) findViewById(R.id.popup_element));
    	pwindo = new PopupWindow(layout, ViewGroup.LayoutParams.WRAP_CONTENT, ViewGroup.LayoutParams.WRAP_CONTENT, true);
    	pwindo.showAtLocation(layout, Gravity.CENTER, 0, 0);
    	
    	final TextView txtname=(TextView)layout.findViewById(R.id.txtname);
    	final TextView txtemail=(TextView)layout.findViewById(R.id.txtemail);
    	final TextView txtreview=(TextView)layout.findViewById(R.id.txtreview);
    	final RatingBar rt1=(RatingBar)layout.findViewById(R.id.txtratting);
    	
    	Button btnsubmit=(Button)layout.findViewById(R.id.btnsubmit);
    	btnsubmit.setOnClickListener(new OnClickListener() {
			
			public void onClick(View v) {
				// TODO Auto-generated method stub
				if(rt1.getRating()>1)
				{
					Log.d("ratting", ""+rt1.getRating());
				if(!txtname.getText().toString().equals("")||!txtemail.getText().toString().equals("")||!txtreview.getText().toString().equals(""))
				{
					if(isValidEmail(txtemail.getText().toString()))
					{
					if (cd.isConnectingToInternet())
					postData(txtname.getText().toString(), txtemail.getText().toString(), rt1.getRating(), txtreview.getText().toString());
					else
						Toast.makeText(CompanyDetails.this, "No Internet Connection Available.", Toast.LENGTH_LONG).show();
					}
					else
						Toast.makeText(CompanyDetails.this, "Email address is not valid.", Toast.LENGTH_LONG).show();
					}
				else
					Toast.makeText(CompanyDetails.this, "Please Fill Up All Detail.", Toast.LENGTH_LONG).show();
				}
				else
					Toast.makeText(CompanyDetails.this, "Please give ratting.", Toast.LENGTH_LONG).show();
			}
		});
    	

    	btnClosePopup = (Button) layout.findViewById(R.id.btn_close_popup);
    	btnClosePopup.setOnClickListener(cancel_button_click_listener);

    	} catch (Exception e) {
    	e.printStackTrace();
    	}
    	}
    private OnClickListener cancel_button_click_listener = new OnClickListener() {
    	public void onClick(View v) {
    	pwindo.dismiss();

    	}
    	};

    	
    	public void postData(String title,String email,Float ratting,String review) {
    	    // Create a new HttpClient and Post Header
    	    HttpClient httpclient = new DefaultHttpClient();
    	    HttpPost httppost = new HttpPost(ConstValue.JSON_REVIEW_ADD);

    	    try {
    	    	Log.d("string", title+companyMap.get("id")+email+" rat :-"+ratting+review);
    	        // Add your data
    	        List<NameValuePair> nameValuePairs = new ArrayList<NameValuePair>(2);
    	        nameValuePairs.add(new BasicNameValuePair("title", title));
    	        nameValuePairs.add(new BasicNameValuePair("company", companyMap.get("id")));
    	        nameValuePairs.add(new BasicNameValuePair("email", email));
    	        nameValuePairs.add(new BasicNameValuePair("ratting", ratting.toString()));
    	        nameValuePairs.add(new BasicNameValuePair("review", review));
    	        nameValuePairs.add(new BasicNameValuePair("add", "yes"));
     	       
    	        httppost.setEntity(new UrlEncodedFormEntity(nameValuePairs));

    	       
    	        // Execute HTTP Post Request
    	        HttpResponse response = httpclient.execute(httppost);
    	        
    	        if(response.getEntity()!=null)
    	        {
    	        	Toast.makeText(CompanyDetails.this,"Review Added Successfully.", Toast.LENGTH_LONG).show();
    	        	pwindo.dismiss();
    	        }
    	        else
    	        {
    	        	Toast.makeText(CompanyDetails.this,"Fail. Could Not Connect To Server.", Toast.LENGTH_LONG).show();
    	        	pwindo.dismiss();
    	        }

    	        
    	    } catch (ClientProtocolException e) {
    	        // TODO Auto-generated catch block
    	    } catch (IOException e) {
    	        // TODO Auto-generated catch block
    	    	Toast.makeText(CompanyDetails.this,"Fail. Could Not Connect To Server.", Toast.LENGTH_LONG).show();
    	    	pwindo.dismiss();
    	    }
    	}
    	
    	 public Drawable getDrawable(String source) {
    	        LevelListDrawable d = new LevelListDrawable();
    	        Drawable empty = getResources().getDrawable(R.drawable.ic_launcher);
    	        d.addLevel(0, 0, empty);
    	        d.setBounds(0, 0, empty.getIntrinsicWidth(), empty.getIntrinsicHeight());

    	        new LoadImage().execute(source, d);

    	        return d;
    	    }

    	    class LoadImage extends AsyncTask<Object, Void, Bitmap> {

    	        private LevelListDrawable mDrawable;

    	        @Override
    	        protected Bitmap doInBackground(Object... params) {
    	            String source = (String) params[0];
    	            mDrawable = (LevelListDrawable) params[1];
    	            Log.d(TAG, "doInBackground " + source);
    	            try {
    	                InputStream is = new URL(source).openStream();
    	                return BitmapFactory.decodeStream(is);
    	            } catch (FileNotFoundException e) {
    	                e.printStackTrace();
    	            } catch (MalformedURLException e) {
    	                e.printStackTrace();
    	            } catch (IOException e) {
    	                e.printStackTrace();
    	            }
    	            return null;
    	        }

    	        @Override
    	        protected void onPostExecute(Bitmap bitmap) {
    	            Log.d(TAG, "onPostExecute drawable " + mDrawable);
    	            Log.d(TAG, "onPostExecute bitmap " + bitmap);
    	            if (bitmap != null) {
    	                BitmapDrawable d = new BitmapDrawable(bitmap);
    	                mDrawable.addLevel(1, 1, d);
    	                mDrawable.setBounds(0, 0, bitmap.getWidth(), bitmap.getHeight());
    	                mDrawable.setLevel(1);
    	                // i don't know yet a better way to refresh TextView
    	                // mTv.invalidate() doesn't work as expected
    	                CharSequence t = mTv.getText();
    	                mTv.setText(t);
    	            }
    	        }
    	    }
    	    
    	    
    	    
    	    
    	    
    		public class LoadReviewTask extends AsyncTask<Boolean, Void, ArrayList<HashMap<String, String>>> {

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
    					
    					settings.edit().putString(ConstValue.PREF_REVIEW+ConstValue.sel_company.get("id"),ObjectSerializer.serialize(reviewList)).commit();
    					
    				} catch (IOException e) {
    					// TODO Auto-generated catch block
    					e.printStackTrace();
    				}
    				reviewadapter.notifyDataSetChanged();
    				//progressBar.setVisibility(View.GONE);
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
    						
    							json = jParser.getJSONFromUrl(ConstValue.JSON_COMPANI_REVIEW+ConstValue.sel_company.get("id"));
    						
    						JSONArray menus = json.getJSONArray("reviews");
    						if(menus!=null)
    						{
    							reviewList.clear();
    							for (int i = 0; i < menus.length(); i++) {
    								JSONObject c = menus.getJSONObject(i);
    								HashMap<String, String> map = new HashMap<String, String>();
    								map.put("id",c.getString("id"));
    								map.put("company",c.getString("company"));
    								map.put("title",c.getString("title"));
    								
    								map.put("email",c.getString("email"));
    								map.put("ratting",c.getString("ratting"));
    								map.put("review",c.getString("review"));
    								
    								map.put("approved",c.getString("approved"));									

    								reviewList.add(map);
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
}
