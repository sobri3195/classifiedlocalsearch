package util.common;

import java.io.BufferedReader;
import java.io.IOException;
import java.io.InputStream;
import java.io.InputStreamReader;
import java.net.HttpURLConnection;
import java.net.URL;

import org.jsoup.Jsoup;

import android.app.AlertDialog;
import android.content.Context;
import android.content.DialogInterface;
import android.content.DialogInterface.OnClickListener;
import android.content.pm.PackageInfo;
import android.content.pm.PackageManager;
import android.content.pm.PackageManager.NameNotFoundException;
import android.graphics.Bitmap;
import android.graphics.Bitmap.Config;
import android.graphics.Canvas;
import android.graphics.Paint;
import android.graphics.PorterDuff.Mode;
import android.graphics.PorterDuffXfermode;
import android.graphics.Rect;
import android.graphics.RectF;
import android.net.ConnectivityManager;
import android.net.Uri;
import android.telephony.TelephonyManager;
import android.util.Log;
import android.view.View;
import android.view.animation.Animation;
import android.view.animation.AnimationUtils;
import android.view.inputmethod.InputMethodManager;

import com.way.magictrik.R;

import defaultconfig.ConstValue;

public class Util {
	/*public static Uri getDirectionUriFrom(GeoPoint destPoint) {
		Uri directionUri = null;
		if(destPoint == null)
			return null;
		
		String mapURL = "http://maps.google.com/maps?saddr=&daddr=";
		StringBuilder mapURLBuilder = new StringBuilder(mapURL);
		DecimalFormat format = new DecimalFormat("######.######");
		mapURLBuilder.append(format.format(((double)destPoint.getLatitudeE6())/1E6));
		mapURLBuilder.append(",");
		mapURLBuilder.append(format.format(((double)destPoint.getLongitudeE6())/1E6));
		
		directionUri = Uri.parse(mapURLBuilder.toString());
		LOG(Constant.LOG_TAG, "Map direction Uri : " + directionUri.toString(), Constant.DEBUG_MODE);
		
		return directionUri;
	}*/
	
	public static Uri getDirectionUriFrom(String destAddr) {
		Uri directionUri = null;
		if(destAddr == null)
			return null;
		
		String mapURL = "http://maps.google.com/maps?saddr=&daddr=";
		StringBuilder mapURLBuilder = new StringBuilder(mapURL);
		mapURLBuilder.append(destAddr);
		
		directionUri = Uri.parse(mapURLBuilder.toString());
		LOG(ConstValue.LOG_TAG, "Map direction Uri : " + directionUri.toString(), ConstValue.DEBUG_MODE);
		
		return directionUri;
	}
	
	public static void LOG(String tag, String message, boolean debugMode) {
		if (message == null)
			return;

		if (debugMode)
			Log.d(tag, message);
	}
	
	/*public static void emailUs(Context c)
	{
		Intent intent = new Intent(Intent.ACTION_SEND);
		intent.setType("text/plain");
		intent.putExtra(Intent.EXTRA_EMAIL, new String[] { Constant.CONTACT_EMAIL_ID});
		intent.putExtra(Intent.EXTRA_SUBJECT, "");
		intent.putExtra(Intent.EXTRA_TEXT, "");
		c.startActivity(intent);
	}
	
	public static void callUs(Context c)
	{
		Intent intent = new Intent(Intent.ACTION_CALL);
		intent.setData(Uri.parse("tel:" + Constant.CONTACT_NO));
		c.startActivity(intent);
	}*/

	/**
	 * It shows the alert message
	 * 
	 * @param context
	 *            - context in which alert message will be displayed
	 * @param title
	 *            - title of the alert box
	 * @param message
	 *            - message to show
	 */
	public static void alertbox(Context context, String message) {
		alertbox(context, message, null);
	}

	public static void alertbox(Context context, String message,
			OnClickListener clickListener) {

		new AlertDialog.Builder(context)
				.setMessage(message)
				.setTitle(context.getString(R.string.message))
				.setCancelable(true)
				.setNeutralButton(
						context.getString(android.R.string.ok),
						clickListener != null ? clickListener
								: new DialogInterface.OnClickListener() {
									public void onClick(DialogInterface dialog,
											int whichButton) {
									}
								}).show();
	}

	/**
	 * This method check the network.
	 * 
	 * @param context
	 *            - context from which this method is called
	 * @return true if network connectivity is avaialbe, false otherwise.
	 */
	public static final boolean isNetworkAvailable(Context context) {
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

	/**
	 * This method print specified input stream in log
	 * 
	 * @param in
	 *            - input stream to be printed in logcat
	 * @throws IOException
	 */
	public static void printInputStream(InputStream in) throws IOException {
		if (in != null) {
			BufferedReader br = new BufferedReader(new InputStreamReader(in));
			String line = "";
			while ((line = br.readLine()) != null) {
				Log.d("PRINT_INPUT_STREAM", line);
			}
		}
	}

	/**
	 * Convert input stream to string
	 * 
	 * @param in
	 *            - input stream to convert
	 * @return - string conversion of given input stream, or null if input
	 *         stream is null
	 * @throws IOException
	 */
	public static String inputStreamToString(InputStream in) throws IOException {
		if (in != null) {
			BufferedReader br = new BufferedReader(new InputStreamReader(in));
			StringBuffer sb = new StringBuffer();
			String line = "";
			while ((line = br.readLine()) != null) {
				sb.append(line);
				// Log.d("PRINT_INPUT_STREAM", line);
			}
			return sb.toString();
		}
		return null;
	}

	/**
	 * Animate view
	 * 
	 * @param context
	 * @param v
	 * @param animationId
	 */
	public static void animate(Context context, View v, int animationId) {
		v.clearAnimation();

		Animation animation = AnimationUtils
				.loadAnimation(context, animationId);
		v.setAnimation(animation);
		animation.start();
	}

	/**
	 * Get version of application
	 * 
	 * @param pm
	 * @param context
	 * @return version name defined in manifest file.
	 */
	public static String getVersion(PackageManager pm, Context context) {
		String version = "-1";
		try {
			PackageInfo pInfo = pm.getPackageInfo(context.getPackageName(),
					PackageManager.GET_META_DATA);
			version = pInfo.versionName;
		} catch (NameNotFoundException e1) {
			e1.printStackTrace();
		}
		return version;
	}

	/**
	 * Modify bitmap to have rounded corners
	 * 
	 * @param bitmap
	 * @return bitmap with rounded corners
	 */
	public static Bitmap getRoundedCornerBitmap(Bitmap bitmap, float roundPx) {
		if (bitmap != null) {
			Bitmap output = Bitmap.createBitmap(bitmap.getWidth(),
					bitmap.getHeight(), Config.ARGB_8888);
			Canvas canvas = new Canvas(output);

			final int color = 0xff424242;
			final Paint paint = new Paint();
			final Rect rect = new Rect(0, 0, bitmap.getWidth(),
					bitmap.getHeight());
			final RectF rectF = new RectF(rect);
			// final float roundPx = 6;

			paint.setAntiAlias(true);
			canvas.drawARGB(0, 0, 0, 0);
			paint.setColor(color);
			canvas.drawRoundRect(rectF, roundPx, roundPx, paint);

			paint.setXfermode(new PorterDuffXfermode(Mode.SRC_IN));
			canvas.drawBitmap(bitmap, rect, rect, paint);

			return output;
		}
		return bitmap;
	}

	/**
	 * Get the unique device id
	 * 
	 * @param context
	 * @return device id
	 */
	public static String getDeviceId(Context context) {
		// String deviceId = Secure.getString(context.getContentResolver(),
		// Secure.ANDROID_ID);
		// return deviceId;
		return ((TelephonyManager) context
				.getSystemService(Context.TELEPHONY_SERVICE)).getDeviceId();
	}

	/**
	 * show/hide soft keyboard
	 * 
	 * @param context
	 * @param v
	 * @param visible
	 */
	public static void setKeyboardVisible(Context context, View v,
			boolean visible) {
		InputMethodManager imm = (InputMethodManager) context
				.getSystemService(Context.INPUT_METHOD_SERVICE);
		if (visible) {
			imm.showSoftInput(v, 0);
		} else {
			imm.hideSoftInputFromWindow(v.getWindowToken(), 0);
		}
	}
	
	public static String urlToHtmlData(String strUrl)
	{
		StringBuffer response = new StringBuffer(""); 
		HttpURLConnection httpURLConnection = null;
		try
		{
			URL url = new URL(strUrl);
		    httpURLConnection = (HttpURLConnection) url.openConnection();
		    httpURLConnection.setRequestMethod("GET");
		    httpURLConnection.setRequestProperty("Content-Type","text/plain; charset:utf-8;");
		    httpURLConnection.setUseCaches (false);
		    httpURLConnection.setDoInput(true);
		    httpURLConnection.setConnectTimeout(30000);
		    httpURLConnection.setReadTimeout(30000);
		    int resCode = httpURLConnection.getResponseCode();      
		    if (resCode == HttpURLConnection.HTTP_OK)
		    {
			    InputStream is = httpURLConnection.getInputStream();
			    String data = inputStreamToString(is);
			    response.append(data);
//			    BufferedReader rd = new BufferedReader(new InputStreamReader(is));
//			    String line;
//			    while((line = rd.readLine()) != null)
//			    {
//			    	response.append(line);
//			    }
//			    rd.close();
		    }
		}
		catch (Exception e)
		{
			e.printStackTrace();
			System.out.println("Connection TimeOut");
		} 
		finally
		{
			if(httpURLConnection != null)
			{
				httpURLConnection.disconnect(); 
		    }
		}
		return response.toString();
	}
	
}
