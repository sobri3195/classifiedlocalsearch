package com.way.magictips;


import com.google.android.gms.ads.AdRequest;
import com.google.android.gms.ads.AdView;
import com.google.android.gms.ads.InterstitialAd;
import com.way.magictrik.R;

import defaultconfig.ConstValue;
import framework.GPSTracker;
import android.os.Bundle;
import android.app.Activity;
import android.content.Context;
import android.content.Intent;
import android.graphics.Typeface;
import android.support.v4.app.Fragment;
import android.support.v4.app.FragmentActivity;
import android.support.v4.app.FragmentManager;
import android.support.v4.app.FragmentPagerAdapter;
import android.support.v4.view.ViewPager;
import android.support.v4.view.ViewPager.OnPageChangeListener;
import android.util.Log;
import android.view.KeyEvent;
import android.view.View;
import android.view.Window;
import android.view.View.OnClickListener;
import android.view.inputmethod.EditorInfo;
import android.view.inputmethod.InputMethodManager;
import android.widget.AdapterView;
import android.widget.Button;
import android.widget.EditText;
import android.widget.HorizontalScrollView;
import android.widget.ImageView;
import android.widget.LinearLayout;
import android.widget.ListView;
import android.widget.TextView;
import android.widget.Toast;

public class CompanyMain extends FragmentActivity implements OnClickListener {
	
	private ViewPager _mViewPager;
	private ViewPagerAdapter _adapter;
	
	Button btnBack;
	EditText txtsearch;
	TextView txtcalc,txttechnical;//,txtlaying;
	
	LinearLayout linearsearch;
	Boolean searchFlag=false;
	String searchstring="";
	GPSTracker gpsTracker;
	Double cur_latitude, cur_longitude;
	@Override
	protected void onCreate(Bundle savedInstanceState) {
		super.onCreate(savedInstanceState);
		requestWindowFeature(Window.FEATURE_NO_TITLE);
		setContentView(R.layout.activity_company_main);
		// Look up the AdView as a resource and load a request.
        /*AdView adView = (AdView)this.findViewById(R.id.adView);
        
        AdRequest adRequest = new AdRequest.Builder()
        .addTestDevice(AdRequest.DEVICE_ID_EMULATOR)
        .addTestDevice("TEST_DEVICE_ID")
        .build();
        adView.loadAd(adRequest);
		*/
		AdView mAdView = (AdView) findViewById(R.id.adView);
        AdRequest adRequest = new AdRequest.Builder().build();
        mAdView.loadAd(adRequest);
gpsTracker = new GPSTracker(CompanyMain.this);
        
        if (gpsTracker.canGetLocation())
        {
        	if(gpsTracker.getLatitude()!=0.0)
        		cur_latitude =	gpsTracker.getLatitude();
        	if(gpsTracker.getLongitude()!=0.0)
        		cur_longitude = gpsTracker.getLongitude();
        }else{
            // can't get location
            // GPS or Network is not enabled
            // Ask user to enable GPS/network in settings
        	gpsTracker.showSettingsAlert();
        	
        }
        
        ConstValue.compList1.clear();
        ConstValue.compList2.clear();
        ConstValue.compList3.clear();
        ConstValue.SEARCH_TEXT = "";
        
		btnBack = (Button)findViewById(R.id.button1);
		btnBack.setOnClickListener(this);
		 Button btnhome=(Button)findViewById(R.id.btnhome);
	        btnhome.setOnClickListener(this);
	        
	        /*ImageView imgslider=(ImageView)findViewById(R.id.imgslider);
	        
	        if(ConstValue.SELECTED_MAINCATEGORY_ID.equals("2"))
	        	imgslider.setImageResource(R.drawable.floor);
	        else if(ConstValue.SELECTED_MAINCATEGORY_ID.equals("3"))
	        	imgslider.setImageResource(R.drawable.vitrified);
	        else if(ConstValue.SELECTED_MAINCATEGORY_ID.equals("4"))
	        	imgslider.setImageResource(R.drawable.sanitary);
	        */
	        linearsearch=(LinearLayout)findViewById(R.id.LinearLayout1);
	        
	        txtsearch=(EditText)findViewById(R.id.txtsearch);
	       // txtsearch.setVisibility(View.GONE);
	      
	        TextView txtheader=(TextView)findViewById(R.id.txtheader);
	        txtheader.setText(ConstValue.SELECTED_MAINCATEGORY_TITLE);
	        txtheader.requestFocus();
	        
	        
	        Button btnsearch=(Button)findViewById(R.id.btnsearch);
			btnsearch.setOnClickListener(this);
			
			 Button btngo=(Button)findViewById(R.id.btngo);
				btngo.setOnClickListener(this);
			
			
//			txtsearch.setOnEditorActionListener(new TextView.OnEditorActionListener() {
//				
//			    public boolean onEditorAction(TextView v, int actionId, KeyEvent event) {
//			        if (actionId == EditorInfo.IME_ACTION_SEARCH) {
//			        	if(!txtsearch.getText().equals(""))
//			        	{
//			        		InputMethodManager imm = (InputMethodManager) getSystemService(Context.INPUT_METHOD_SERVICE);
//			        		imm.hideSoftInputFromWindow(txtsearch.getWindowToken(), 0);
//			        		
//			            return true;
//			        	}
//			        	else
//			        		Toast.makeText(getApplicationContext(), "Please Enter Some Character", Toast.LENGTH_LONG).show();
//			        }
//			        return false;
//			    }
//			});
			
//			 AdView adView = (AdView)this.findViewById(R.id.adView);
//		        adView.loadAd(new AdRequest());

		txtcalc=(TextView)findViewById(R.id.txtcalc);
		txttechnical=(TextView)findViewById(R.id.txttechnical);
		//txtlaying=(TextView)findViewById(R.id.txtlaying);
		
		txtcalc.setOnClickListener(this);
		txttechnical.setOnClickListener(this);
//		txtlaying.setOnClickListener(this);

		txtcalc.setTextColor(0xff485760);
		txtcalc.setTypeface(null, Typeface.BOLD);
		
		findViewById(R.id.first_text).setOnClickListener(this);
		findViewById(R.id.second_text).setOnClickListener(this);
		
		
		_mViewPager = (ViewPager) findViewById(R.id.profilePager);
	     _adapter = new ViewPagerAdapter(getApplicationContext(),getSupportFragmentManager(),this);
	     _mViewPager.setAdapter(_adapter);
		 _mViewPager.setCurrentItem(0);
		
		 setTab();
		// setTab(3);
		 
		
	}
	

	public void onClick(View v) {
		// TODO Auto-generated method stub
		switch(v.getId())
		{
		
		case R.id.btnhome:
			Intent intent=new Intent(CompanyMain.this,HomeActiviry.class);
			startActivity(intent);
			overridePendingTransition(R.anim.animation_enter,R.anim.animation_leave);
			break;
		case R.id.button1:
			finish();
			break;
		case R.id.btnsearch:
			if(linearsearch.getVisibility()==View.GONE)
				linearsearch.setVisibility(View.VISIBLE);
			else
				linearsearch.setVisibility(View.GONE);
			break;
		case R.id.btngo:
			
			if(linearsearch.getVisibility()!=View.GONE && !txtsearch.getText().equals(""))
			{
				InputMethodManager imm = (InputMethodManager) getSystemService(Context.INPUT_METHOD_SERVICE);
        		imm.hideSoftInputFromWindow(txtsearch.getWindowToken(), 0);
        		ConstValue.SEARCH_TEXT=txtsearch.getText().toString();
        		Log.d("searching set", ConstValue.SEARCH_TEXT);
        		ListView listsearch=(ListView)_mViewPager.getChildAt(0).findViewById(R.id.listView1);
        		
        	if(listsearch.getCount()>0)
        		{
        		_mViewPager.removeAllViews();
        		
        		 _adapter = new ViewPagerAdapter(getApplicationContext(),getSupportFragmentManager(),this);
        	     _mViewPager.setAdapter(_adapter);
        		 _mViewPager.setCurrentItem(0);
        		 setTab();
        	
        		}
        	linearsearch.setVisibility(View.GONE);
			}
			else
			{
				linearsearch.setVisibility(View.VISIBLE);
			}
			break;
		case R.id.first_text:
			_mViewPager.setCurrentItem(0);
			break;
		case R.id.second_text:
			_mViewPager.setCurrentItem(1);
			break;
//		case R.id.txtlaying:
//			_mViewPager.setCurrentItem(3);
//			break;
			
		}
		
	}
	
	public class ViewPagerAdapter extends FragmentPagerAdapter {
		private Context _context;
		public Activity acs;
		public  int totalPage=2;
		public ViewPagerAdapter(Context context, FragmentManager fm, Activity ac) {
			super(fm);	
			_context=context;
			acs = ac;
			}
		@Override
		public Fragment getItem(int position) {
			Fragment f = new Fragment();
			switch(position){
			case 0:
				f=CompanyList.newInstance(_context,acs);
				break;
			case 1:
				f=CompanyListNearby.newInstance(_context,acs,cur_latitude,cur_longitude);
				break;
			
			}
			return f;
		}
		@Override
		public int getCount() {
			return totalPage;
		}
	}
	private void setTab(){
		_mViewPager.setOnPageChangeListener(new OnPageChangeListener(){
		    		
					public void onPageScrollStateChanged(int position) {
					}
					public void onPageScrolled(int arg0, float arg1, int arg2) {}
					
					public void onPageSelected(int position) {
						// TODO Auto-generated method stub
						switch(position){
						case 0:
							linearsearch.setVisibility(View.GONE);
							//_mViewPager.setCurrentItem(2);
							//linearsearch.setVisibility(View.VISIBLE);
							//ConstValue.SELECTED_TAB_ID=1;
							txtcalc.setTextColor(0xff485760);
							txtcalc.setTypeface(null, Typeface.BOLD);
							
						//	txttechnical.setTextColor(0xfff7f7f7);
							txttechnical.setTypeface(null, Typeface.NORMAL);
							
						//	txtlaying.setTextColor(0xfff7f7f7);
							//txtlaying.setTypeface(null, Typeface.NORMAL);
							
							
							findViewById(R.id.first_tab).setVisibility(View.VISIBLE);
							findViewById(R.id.second_tab).setVisibility(View.INVISIBLE);
							//findViewById(R.id.third_tab).setVisibility(View.INVISIBLE);
							
							_mViewPager.getAdapter().notifyDataSetChanged();
							
							break;							
						case 1:
							linearsearch.setVisibility(View.GONE);
							//ConstValue.SELECTED_TAB_ID=2;
						//	txtcalc.setTextColor(0xfff7f7f7);
							txtcalc.setTypeface(null, Typeface.NORMAL);
							
						//	txttechnical.setTextColor(0xff485760);
							txttechnical.setTypeface(null, Typeface.BOLD);
							
						//	txtlaying.setTextColor(0xfff7f7f7);
						//	txtlaying.setTypeface(null, Typeface.NORMAL);
							
							
							findViewById(R.id.first_tab).setVisibility(View.INVISIBLE);
							findViewById(R.id.second_tab).setVisibility(View.VISIBLE);
							//findViewById(R.id.third_tab).setVisibility(View.INVISIBLE);
							
							_mViewPager.getAdapter().notifyDataSetChanged();
							
							break;
							
						case 2:
							
							
							break;
						case 3:
							//ConstValue.SELECTED_TAB_ID=3;
							linearsearch.setVisibility(View.GONE);
						//	txtcalc.setTextColor(0xfff7f7f7);
							txtcalc.setTypeface(null, Typeface.NORMAL);
							
						//	txttechnical.setTextColor(0xfff7f7f7);
							txttechnical.setTypeface(null, Typeface.NORMAL);
							
						//	txtlaying.setTextColor(0xff485760);
						//	txtlaying.setTypeface(null, Typeface.BOLD);
							
							
							findViewById(R.id.first_tab).setVisibility(View.INVISIBLE);
							findViewById(R.id.second_tab).setVisibility(View.INVISIBLE);
						//	findViewById(R.id.third_tab).setVisibility(View.VISIBLE);
							break;
						
						case 4:
							//linearsearch.setVisibility(View.VISIBLE);
						//	_mViewPager.setCurrentItem(1);
							break;
						}
					}
				});
		}
}
