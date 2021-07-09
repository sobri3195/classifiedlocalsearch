package framework;

import org.jsoup.Jsoup;

import com.way.magictrik.R;

import android.app.Activity;
import android.app.AlertDialog;
import android.content.Context;
import android.content.Intent;
import android.net.ConnectivityManager;
import android.net.Uri;
import android.os.Bundle;
import android.text.Spanned;
import android.view.View;
import android.view.Window;
import android.widget.TextView;
import android.widget.Toast;

public class BaseActivity extends Activity {
	AlertDialog.Builder loadingBuilder;
	AlertDialog loadingDialog;
	@Override
	protected void onCreate(Bundle savedInstanceState) {
		super.onCreate(savedInstanceState);
		requestWindowFeature(Window.FEATURE_NO_TITLE);
	}
	
	protected View getProgressBar() {
		return findViewById(R.id.progressBarView);
	}
	protected void setProgressBarVisibility(int visibility) {
		View progressBar = getProgressBar();
		if (progressBar != null) {
			progressBar.setVisibility(visibility);
			
		}
	}
	
	
	//------------title gatter -----------//
	private TextView getHeaderTitleView() {
		TextView headerTitle = (TextView) findViewById(R.id.headerTitle);
		return headerTitle;
	}
	//----------- title setter -----------//
	protected void setHeaderTitle(String title) {
		TextView headerTitle = getHeaderTitleView();
		if (headerTitle != null) {
			headerTitle.setText(title);
		} else {
			setTitle(title);
		}
	}
	
	public static Uri getDirectionUriFrom(String destAddr) {
		  Uri directionUri = null;
		  if(destAddr == null)
		   return null;
		  
		  String mapURL = "http://maps.google.com/maps?saddr=&daddr=";
		  StringBuilder mapURLBuilder = new StringBuilder(mapURL);
		  mapURLBuilder.append(destAddr);
		  
		  directionUri = Uri.parse(mapURLBuilder.toString());
		 // LOG(Constant.LOG_TAG, "Map direction Uri : " + directionUri.toString(), Constant.DEBUG_MODE);
		  
		  return directionUri;
		 }
	public void findLocation(String locationlink)
	{
			Intent intent1 = new Intent(android.content.Intent.ACTION_VIEW, getDirectionUriFrom(locationlink));
		startActivity(intent1);
		
	}
	public final static boolean isValidEmail(CharSequence target) {
	    if (target == null) {
	        return false;
	    } else {
	        return android.util.Patterns.EMAIL_ADDRESS.matcher(target).matches();
	    }
	}
	
	public void LoadingDialogBox(String open)
	{
		  if(open=="open")
		  {
				loadingBuilder = new AlertDialog.Builder(this);  
				loadingBuilder.setTitle("Loading wait...");  
		       //final TextView input = new TextView(this);  
		    
		       //input.setText("Loading please wait.."); //Set the text we want to edit  
		       
		       View myView = null;
		       myView = getLayoutInflater().inflate(R.layout.progressbar_view, null);
		       
		       loadingBuilder.setView(myView);        
		        
		       // Remember, create doesn't show the dialog  
		       loadingDialog = loadingBuilder.create();  
		       loadingDialog.show();  
		       loadingDialog.setCancelable(false);
		       loadingDialog.setCanceledOnTouchOutside(false);
		  }else if(open=="close")
		  {
			  loadingDialog.cancel();
		  }
	}
	
	//---------html to text-----------//
	public String html2text(String html) {
		if(html!=null)
	    return Jsoup.parse(html).text();
		else
			return null;
	}
	
	public boolean isNetworkAvailable(Context context) {
		final ConnectivityManager connMgr = (ConnectivityManager) context
				.getSystemService(Context.CONNECTIVITY_SERVICE);

		final android.net.NetworkInfo wifi = connMgr
				.getNetworkInfo(ConnectivityManager.TYPE_WIFI);
		final android.net.NetworkInfo mobile = connMgr
				.getNetworkInfo(ConnectivityManager.TYPE_MOBILE);
		
		if (wifi.isAvailable() || mobile.isAvailable())
			return true;
		else
			return false;
	}
	
	public void sendBaseEmail(String subject,Spanned message, String emailAddress)
	{
			if(!emailAddress.equals(""))
			{
				Intent email = new Intent(Intent.ACTION_SEND);
				  email.setType("text/html");
				  email.putExtra(Intent.EXTRA_EMAIL, new String[]{ emailAddress});
				  //email.putExtra(Intent.EXTRA_CC, new String[]{ to});
				  //email.putExtra(Intent.EXTRA_BCC, new String[]{to});
				  email.putExtra(Intent.EXTRA_SUBJECT, subject);
				  email.putExtra(Intent.EXTRA_TEXT, message);
				  startActivity(Intent.createChooser(email, "Choose an Email client :"));
			}
			else
				Toast.makeText(BaseActivity.this,"No Email Address Found.", Toast.LENGTH_LONG).show();
	}
}
