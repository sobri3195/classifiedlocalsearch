package com.way.magictips;



import java.io.BufferedReader;
import java.io.IOException;
import java.io.InputStream;
import java.io.InputStreamReader;
import java.net.HttpURLConnection;
import java.net.URL;
import java.util.ArrayList;
import java.util.HashMap;
import java.util.List;
import org.json.JSONObject;
import com.google.android.gms.ads.AdRequest;
import com.google.android.gms.ads.AdView;
import com.google.android.gms.common.ConnectionResult;
import com.google.android.gms.common.GooglePlayServicesUtil;
import com.google.android.gms.maps.CameraUpdateFactory;
import com.google.android.gms.maps.GoogleMap;
import com.google.android.gms.maps.MapFragment;
import com.google.android.gms.maps.MapsInitializer;
import com.google.android.gms.maps.model.BitmapDescriptorFactory;
import com.google.android.gms.maps.model.CameraPosition;
import com.google.android.gms.maps.model.LatLng;
import com.google.android.gms.maps.model.MarkerOptions;
import com.google.android.gms.maps.model.PolylineOptions;
import com.way.magictrik.R;
import framework.DirectionsJSONParser;
import framework.GPSTracker;
import android.os.AsyncTask;
import android.os.Bundle;
import android.annotation.SuppressLint;
import android.graphics.Color;
import android.util.Log;
import android.view.View;
import android.view.Window;
import android.view.View.OnClickListener;
import android.widget.Button;
import android.support.v4.app.FragmentActivity;

@SuppressLint("NewApi")
public class MapActivity extends FragmentActivity implements OnClickListener {
   static final LatLng TutorialsPoint = new LatLng(21 , 57);
   private GoogleMap map;
   ArrayList<LatLng> markerPoints;
   @SuppressLint("NewApi")
@Override
   protected void onCreate(Bundle savedInstanceState) {
      super.onCreate(savedInstanceState);
      requestWindowFeature(Window.FEATURE_NO_TITLE);
      setContentView(R.layout.activity_map);
      MapsInitializer.initialize(getApplicationContext());
      
      // Look up the AdView as a resource and load a request.
      AdView mAdView = (AdView) findViewById(R.id.adView);
      AdRequest adRequest = new AdRequest.Builder().build();
      mAdView.loadAd(adRequest);
     // adView.loadAd(new AdRequest());
      
      Button btnback=(Button)findViewById(R.id.btnback);
		btnback.setOnClickListener(this);
		
		int status = GooglePlayServicesUtil.isGooglePlayServicesAvailable(getApplicationContext());
	    if(status == ConnectionResult.SUCCESS) {
	        //Success! Do what you want
	    	Log.d("Google Play Service is :", "Enabled");
	    }else{
	        GooglePlayServicesUtil.getErrorDialog(status, this, status);
	    }
            if (map == null) {
            	map = ((MapFragment) getFragmentManager().
               findFragmentById(R.id.map)).getMap();
            }
         // Initializing 
    		markerPoints = new ArrayList<LatLng>();
            // check if GPS enabled
    		
    		
            GPSTracker gpsTracker = new GPSTracker(this);
            
            if (gpsTracker.canGetLocation())
            {
            	Log.d("gps track location vijay", ""+gpsTracker.latitude);
            	//markerPoints.add(new LatLng(gpsTracker.latitude,gpsTracker.longitude));
            	onMapClick(new LatLng(gpsTracker.latitude,gpsTracker.longitude));
            //	markerPoints.add(new LatLng(22.8103239,70.8565892));
            	onMapClick(new LatLng(getIntent().getExtras().getDouble("latitude"),getIntent().getExtras().getDouble("longitude")));
            	CameraPosition cameraPosition = new CameraPosition.Builder().target(
                        new LatLng(gpsTracker.latitude,gpsTracker.longitude)).zoom(12).build();
         
            	map.animateCamera(CameraUpdateFactory.newCameraPosition(cameraPosition));

            }
            
            
    
   }
   public void onMapClick(LatLng point) {
		
		
		
		// Adding new item to the ArrayList
		markerPoints.add(point);				
		
		// Creating MarkerOptions
		MarkerOptions options = new MarkerOptions();
		
		// Setting the position of the marker
		
		/** 
		 * For the start location, the color of marker is GREEN and
		 * for the end location, the color of marker is RED.
		 */
		if(markerPoints.size()==1){
			options.position(point).title(getIntent().getExtras().getString("company")).icon(BitmapDescriptorFactory.fromResource(R.drawable.location_blue));
			//options.icon(BitmapDescriptorFactory.defaultMarker());
			//options.icon(BitmapDescriptorFactory.fromResource(R.drawable.location_blue));
			
		}else if(markerPoints.size()==2){
			options.position(point).title("My Position").icon(BitmapDescriptorFactory.fromResource(R.drawable.location_red));
			//options.icon(BitmapDescriptorFactory.defaultMarker());
			//options.icon(BitmapDescriptorFactory.fromResource(R.drawable.location_red));
		}
					
		
		// Add new marker to the Google Map Android API V2
		map.addMarker(options);
		
		
		// Checks, whether start and end locations are captured
		if(markerPoints.size() >= 2){					
			LatLng origin = markerPoints.get(0);
			LatLng dest = markerPoints.get(1);
			
			// Getting URL to the Google Directions API
			String url = getDirectionsUrl(origin, dest);				
			
			DownloadTask downloadTask = new DownloadTask();
			
			// Start downloading json data from Google Directions API
			downloadTask.execute(url);
		}
		
	}
public void onClick(View v) {
	// TODO Auto-generated method stub
	switch(v.getId())
	{
	
	case R.id.btnback:
		finish();
		break;
	default:
		break;
	}
	
	
}

private String getDirectionsUrl(LatLng origin,LatLng dest){
	
	// Origin of route
	String str_origin = "origin="+origin.latitude+","+origin.longitude;
	
	// Destination of route
	String str_dest = "destination="+dest.latitude+","+dest.longitude;		
	
				
	// Sensor enabled
	String sensor = "sensor=false";			
				
	// Building the parameters to the web service
	String parameters = str_origin+"&"+str_dest+"&"+sensor;
				
	// Output format
	String output = "json";
	
	// Building the url to the web service
	String url = "https://maps.googleapis.com/maps/api/directions/"+output+"?"+parameters;
	
	
	return url;
}

/** A method to download json data from url */
private String downloadUrl(String strUrl) throws IOException{
    String data = "";
    InputStream iStream = null;
    HttpURLConnection urlConnection = null;
    try{
            URL url = new URL(strUrl);

            // Creating an http connection to communicate with url 
            urlConnection = (HttpURLConnection) url.openConnection();

            // Connecting to url 
            urlConnection.connect();

            // Reading data from url 
            iStream = urlConnection.getInputStream();

            BufferedReader br = new BufferedReader(new InputStreamReader(iStream));

            StringBuffer sb  = new StringBuffer();

            String line = "";
            while( ( line = br.readLine())  != null){
                    sb.append(line);
            }
            
            data = sb.toString();

            br.close();

    }catch(Exception e){
            Log.d("Exception while downloading url", e.toString());
    }finally{
            iStream.close();
            urlConnection.disconnect();
    }
    return data;
 }


// Fetches data from url passed
private class DownloadTask extends AsyncTask<String, Void, String>{			
			
	// Downloading data in non-ui thread
	@Override
	protected String doInBackground(String... url) {
			
		// For storing data from web service
		String data = "";
				
		try{
			// Fetching the data from web service
			data = downloadUrl(url[0]);
		}catch(Exception e){
			Log.d("Background Task",e.toString());
		}
		return data;		
	}
	
	// Executes in UI thread, after the execution of
	// doInBackground()
	@Override
	protected void onPostExecute(String result) {			
		super.onPostExecute(result);			
		
		ParserTask parserTask = new ParserTask();
		
		// Invokes the thread for parsing the JSON data
		parserTask.execute(result);
			
	}		
}

/** A class to parse the Google Places in JSON format */
private class ParserTask extends AsyncTask<String, Integer, List<List<HashMap<String,String>>> >{
	
	// Parsing the data in non-ui thread    	
	@Override
	protected List<List<HashMap<String, String>>> doInBackground(String... jsonData) {
		
		JSONObject jObject;	
		List<List<HashMap<String, String>>> routes = null;			           
        
        try{
        	jObject = new JSONObject(jsonData[0]);
        	DirectionsJSONParser parser = new DirectionsJSONParser();
        	
        	// Starts parsing data
        	routes = parser.parse(jObject);    
        }catch(Exception e){
        	e.printStackTrace();
        }
        return routes;
	}
	
	// Executes in UI thread, after the parsing process
	@Override
	protected void onPostExecute(List<List<HashMap<String, String>>> result) {
		ArrayList<LatLng> points = null;
		PolylineOptions lineOptions = null;
		MarkerOptions markerOptions = new MarkerOptions();
		
		// Traversing through all the routes
		for(int i=0;i<result.size();i++){
			points = new ArrayList<LatLng>();
			lineOptions = new PolylineOptions();
			
			// Fetching i-th route
			List<HashMap<String, String>> path = result.get(i);
			
			// Fetching all the points in i-th route
			for(int j=0;j<path.size();j++){
				HashMap<String,String> point = path.get(j);					
				
				double lat = Double.parseDouble(point.get("lat"));
				double lng = Double.parseDouble(point.get("lng"));
				LatLng position = new LatLng(lat, lng);	
				
				points.add(position);						
			}
			
			// Adding all the points in the route to LineOptions
			lineOptions.addAll(points);
			lineOptions.width(2);
			lineOptions.color(Color.RED);	
			
		}
		
		// Drawing polyline in the Google Map for the i-th route
		map.addPolyline(lineOptions);							
	}			
}   

}