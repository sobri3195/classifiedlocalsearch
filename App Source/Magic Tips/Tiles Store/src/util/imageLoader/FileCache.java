package util.imageLoader;

import java.io.File;

import android.content.Context;

public class FileCache {
    
    private File cacheDir;
    private String CACHE_DIR = "leicestercollege_cache";
    
    public FileCache(Context context){
        //Find the dir to save cached images
        if (android.os.Environment.getExternalStorageState().equals(android.os.Environment.MEDIA_MOUNTED))
            cacheDir=new File(android.os.Environment.getExternalStorageDirectory(),CACHE_DIR);
        else
            cacheDir=context.getCacheDir();
        
        if(!cacheDir.exists())
            cacheDir.mkdirs();
    }
    
    public File getFile(String url){
        //I identify images by hashcode. Not a perfect solution, good for the demo.
    	
    	try
    	{
            String filename=String.valueOf(url.hashCode());
            
            System.out.println("=======> filename => "+filename);
            
            File f = new File(cacheDir, filename);
            return f;
    	}
    	catch(Exception e)
    	{
    		e.printStackTrace();
    		return null;
    	}
    }
    
    public void clear(){
        File[] files=cacheDir.listFiles();
        for(File f:files)
            f.delete();
    }

}