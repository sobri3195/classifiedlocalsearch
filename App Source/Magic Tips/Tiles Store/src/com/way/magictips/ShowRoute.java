package com.way.magictips;


import framework.GPSTracker;
import android.app.Activity;
import android.os.Bundle;
import android.util.Log;
import android.view.Menu;
import android.view.MenuItem;
import android.webkit.WebView;
import com.way.magictrik.R;

public class ShowRoute extends Activity {
	WebView webview;
	@Override
	protected void onCreate(Bundle savedInstanceState) {
		super.onCreate(savedInstanceState);
		setContentView(R.layout.show_route);
		
		webview = (WebView)findViewById(R.id.webView1);
		GPSTracker gpsTracker = new GPSTracker(this);
        
        if (gpsTracker.canGetLocation())
        {
        	Log.d("gps track location vijay", ""+gpsTracker.latitude);
        	//markerPoints.add(new LatLng(gpsTracker.latitude,gpsTracker.longitude));
        	
        	double lat = gpsTracker.latitude;
        	double lon = gpsTracker.longitude;
        	
        	double dlat = getIntent().getExtras().getDouble("latitude");
        	double dlon = getIntent().getExtras().getDouble("longitude");
        	
        	String url = "http://maps.google.com/maps?saddr=@"+dlat+","+dlon+"&daddr=@"+lat+","+lon;
        	webview.loadUrl(url);

        }
	}

	@Override
	public boolean onCreateOptionsMenu(Menu menu) {
		// Inflate the menu; this adds items to the action bar if it is present.
		getMenuInflater().inflate(R.menu.show_route, menu);
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
