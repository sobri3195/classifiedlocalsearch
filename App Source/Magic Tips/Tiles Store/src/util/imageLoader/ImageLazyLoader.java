package util.imageLoader;

import java.io.File;
import java.io.FileInputStream;
import java.io.FileNotFoundException;
import java.io.FileOutputStream;
import java.io.IOException;
import java.io.InputStream;
import java.io.OutputStream;
import java.util.Collections;
import java.util.Map;
import java.util.Stack;
import java.util.WeakHashMap;

import org.apache.http.HttpResponse;
import org.apache.http.HttpStatus;
import org.apache.http.client.ClientProtocolException;
import org.apache.http.client.methods.HttpGet;
import org.apache.http.impl.client.DefaultHttpClient;
import org.apache.http.params.BasicHttpParams;
import org.apache.http.params.HttpConnectionParams;
import org.apache.http.params.HttpParams;



import com.way.magictrik.R;

import android.app.Activity;
import android.content.Context;
import android.graphics.Bitmap;
import android.graphics.BitmapFactory;
import android.widget.ImageView;
import android.widget.ImageView.ScaleType;

public class ImageLazyLoader {
    
    private static MemoryCache memoryCache=new MemoryCache();
    private static FileCache fileCache;
    private Map<ImageView, String> imageViews=Collections.synchronizedMap(new WeakHashMap<ImageView, String>());
    private Quality quality;
//    private Context context;
    
    public static enum Quality {
		MEDIUM, HIGH, EXTRA_HIGH, EXTREME_HIGH
	}
    
    public interface ManageBitmap{
    	public void onImageSet(ImageView imageView, Bitmap bitmap);
    }
    
    private ManageBitmap manageBitmapListener;
    
    public void setManageBitmapListener(ManageBitmap manageBitmapListener){
    	this.manageBitmapListener = manageBitmapListener;
    }
    
    public ImageLazyLoader(Context context, Quality quality){
        //Make the background thead low priority. This way it will not affect the UI performance
//    	this.context = context;
    	this.quality = quality;
    	
        photoLoaderThread.setPriority(Thread.NORM_PRIORITY-1);
        
        fileCache=new FileCache(context);
    }
    
    public ImageLazyLoader(Context context){
        //Make the background thead low priority. This way it will not affect the UI performance
//    	this.context = context;
    	
        photoLoaderThread.setPriority(Thread.NORM_PRIORITY-1);
        
        fileCache=new FileCache(context);
    }
    
    final int stub_id=R.drawable.no_logo;
   // final int stub_id = android.R.color.white;
    
    public void DisplayImage(String url, Activity activity, ImageView imageView)
    {
        imageViews.put(imageView, url);
        Bitmap bitmap=memoryCache.get(url);
        if(bitmap!=null)
        {
        	imageView.setScaleType(ScaleType.FIT_CENTER);
            imageView.setImageBitmap(bitmap);
            
            if(this.manageBitmapListener!=null)
            {
            	manageBitmapListener.onImageSet(imageView, bitmap);
            }
        }
        else
        {
            queuePhoto(url, activity, imageView);
//            imageView.setImageResource(stub_id);
        }    
    }
    
    private void queuePhoto(String url, Activity activity, ImageView imageView)
    {
        //This ImageView may be used for other images before. So there may be some old tasks in the queue. We need to discard them. 
        photosQueue.Clean(imageView);
        PhotoToLoad p=new PhotoToLoad(url, imageView);
        synchronized(photosQueue.photosToLoad){
            photosQueue.photosToLoad.push(p);
            photosQueue.photosToLoad.notifyAll();
        }
        
        //start thread if it's not started yet
        if(photoLoaderThread.getState()==Thread.State.NEW)
            photoLoaderThread.start();
    }
    
    private Bitmap getBitmap(String url) 
    {
        File f=fileCache.getFile(url);
        
        //from SD cache
        Bitmap b = decodeFile(f);
        if(b!=null)
            return b;
        
        //from web
        /*try {
            Bitmap bitmap=null;
            URL imageUrl = new URL(url);
            HttpURLConnection conn = (HttpURLConnection)imageUrl.openConnection();
            conn.setConnectTimeout(30000);
            conn.setReadTimeout(30000);
            conn.setInstanceFollowRedirects(true);
            InputStream is=conn.getInputStream();
            OutputStream os = new FileOutputStream(f);
            copyStream(is, os);
            os.close();
            bitmap = decodeFile(f);
            return bitmap;
        } catch (Exception ex){
           ex.printStackTrace();
           return null;
        }*/
        Bitmap bitmap = null;
        
        try {
        	String encodedURL = url.replace("[", "%5B")
        							.replace("]", "%5D")
        							.replace(" ", "%20");
//        	String encodedURL = URLEncoder.encode(url,"ISO-8859-1");
        	System.out.println("encoded url : " + encodedURL);
        	HttpGet get = new HttpGet(encodedURL);
            
            HttpParams httpParameters = new BasicHttpParams();
            int timeoutConnection = 3000;
            HttpConnectionParams.setConnectionTimeout(httpParameters, timeoutConnection);
            
            DefaultHttpClient client = new DefaultHttpClient(httpParameters);
			HttpResponse response = client.execute(get);
			if(response.getStatusLine().getStatusCode() == HttpStatus.SC_OK) {
				InputStream is=response.getEntity().getContent();
	            OutputStream os = new FileOutputStream(f);
	            CopyStream(is, os);
	            os.close();
	            bitmap = decodeFile(f);
	            return bitmap;
			}
		} catch (ClientProtocolException e) {
			e.printStackTrace();
		} catch (IOException e) {
			e.printStackTrace();
		} catch(Exception e) {
			e.printStackTrace();
		}
        return bitmap;
    }

    //decodes image and scales it to reduce memory consumption
    private Bitmap decodeFile(File f){
        try {
            //decode image size
            BitmapFactory.Options o = new BitmapFactory.Options();
            o.inJustDecodeBounds = true;
            BitmapFactory.decodeStream(new FileInputStream(f),null,o);
            
            //Find the correct scale value. It should be the power of 2.
            int REQUIRED_SIZE=70;
            
            if(quality!=null)
            {
            	 switch (quality) {
     			case MEDIUM:
     				REQUIRED_SIZE = 90;
     				break;
     			case HIGH:
     				REQUIRED_SIZE = 110;

     			case EXTRA_HIGH:
     				REQUIRED_SIZE = 150;
     				
     			case EXTREME_HIGH:
     				REQUIRED_SIZE = 170;
     			default:
     				break;
     			}
            }
            
            int width_tmp=o.outWidth, height_tmp=o.outHeight;
            int scale=1;
            while(true){
                if(width_tmp/2<REQUIRED_SIZE || height_tmp/2<REQUIRED_SIZE)
                    break;
                width_tmp/=2;
                height_tmp/=2;
                scale*=2;
            }
            
            //decode with inSampleSize
            BitmapFactory.Options o2 = new BitmapFactory.Options();
            o2.inSampleSize=scale;
            return BitmapFactory.decodeStream(new FileInputStream(f), null, o2);
        } catch (FileNotFoundException e) {}
        return null;
    }
    
    //Task for the queue
    private class PhotoToLoad
    {
        public String url;
        public ImageView imageView;
        public PhotoToLoad(String u, ImageView i){
            url=u; 
            imageView=i;
        }
    }
    
    PhotosQueue photosQueue=new PhotosQueue();
    
    public void stopThread()
    {
        photoLoaderThread.interrupt();
    }
    
    //stores list of photos to download
    class PhotosQueue
    {
        private Stack<PhotoToLoad> photosToLoad=new Stack<PhotoToLoad>();
        
        //removes all instances of this ImageView
        public void Clean(ImageView image)
        {
            for(int j=0 ;j<photosToLoad.size();){
                if(photosToLoad.get(j).imageView==image)
                    photosToLoad.remove(j);
                else
                    ++j;
            }
        }
    }
    
    class PhotosLoader extends Thread {
        public void run() {
            try {
                while(true)
                {
                    //thread waits until there are any images to load in the queue
                    if(photosQueue.photosToLoad.size()==0)
                        synchronized(photosQueue.photosToLoad){
                            photosQueue.photosToLoad.wait();
                        }
                    if(photosQueue.photosToLoad.size()!=0)
                    {
                        PhotoToLoad photoToLoad;
                        synchronized(photosQueue.photosToLoad){
                            photoToLoad=photosQueue.photosToLoad.pop();
                        }
                        Bitmap bmp=getBitmap(photoToLoad.url);
                        memoryCache.put(photoToLoad.url, bmp);
                        String tag=imageViews.get(photoToLoad.imageView);
                        if(tag!=null && tag.equals(photoToLoad.url)){
                            BitmapDisplayer bd=new BitmapDisplayer(bmp, photoToLoad.imageView);
                            Activity a=(Activity)photoToLoad.imageView.getContext();
                            a.runOnUiThread(bd);
                        }
                    }
                    if(Thread.interrupted())
                        break;
                }
            } catch (InterruptedException e) {
                //allow thread to exit
            }
        }
    }
    
    PhotosLoader photoLoaderThread=new PhotosLoader();
    
    //Used to display bitmap in the UI thread
    class BitmapDisplayer implements Runnable
    {
        Bitmap bitmap;
        ImageView imageView;
        public BitmapDisplayer(Bitmap b, ImageView i){bitmap=b;imageView=i;}
        public void run()
        {
        	if(manageBitmapListener!=null)
            {
            	manageBitmapListener.onImageSet(imageView, bitmap);
            }
            if(bitmap!=null) {
            	imageView.setScaleType(ScaleType.FIT_XY);
            	imageView.setImageBitmap(bitmap);
            } else {
            	imageView.setScaleType(ScaleType.CENTER_INSIDE);
                imageView.setImageResource(stub_id); 
            }
            
            
        }
    }

    public static void clearCache() {
        memoryCache.clear();
        fileCache.clear();
    }
    
	public void CopyStream(InputStream is, OutputStream os) {
		final int buffer_size = 1024;
		try {
			byte[] bytes = new byte[buffer_size];
			for (;;) {
				int count = is.read(bytes, 0, buffer_size);
				if (count == -1)
					break;
				os.write(bytes, 0, count);
			}
		} catch (Exception ex) {
		}
	}

}
