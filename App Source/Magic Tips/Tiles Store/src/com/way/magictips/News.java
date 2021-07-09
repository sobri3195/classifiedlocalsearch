package com.way.magictips;

import java.io.InputStream;
import java.util.ArrayList;
import java.util.Currency;
import java.util.HashMap;
import javax.xml.parsers.SAXParser;
import javax.xml.parsers.SAXParserFactory;
import org.apache.http.HttpResponse;
import org.apache.http.HttpStatus;
import org.apache.http.client.methods.HttpGet;
import org.apache.http.impl.client.DefaultHttpClient;
import org.xml.sax.Attributes;
import org.xml.sax.SAXException;
import org.xml.sax.helpers.DefaultHandler;
import com.way.magictrik.R;
import defaultconfig.ConstValue;
import framework.BaseActivity;
import android.os.AsyncTask;
import android.os.Bundle;
import android.app.Activity;
import android.content.Context;
import android.content.Intent;
import android.util.Log;
import android.view.LayoutInflater;
import android.view.Menu;
import android.view.View;
import android.view.ViewGroup;
import android.widget.AdapterView;
import android.widget.AdapterView.OnItemClickListener;
import android.widget.BaseAdapter;
import android.widget.ListView;
import android.widget.TextView;

public class News extends BaseActivity implements OnItemClickListener {

	@Override
	protected void onCreate(Bundle savedInstanceState) {
		super.onCreate(savedInstanceState);
		setContentView(R.layout.news);		
		new NewsTask().execute();
	}
	public void setNewsAdapter(ArrayList<HashMap<String, String>> list)
	{
		NewsAdapter adapter = new NewsAdapter(this, list);
		ListView newsList = (ListView)findViewById(R.id.listView1);
		newsList.setAdapter(adapter);
		ConstValue.newsList = list;
		newsList.setOnItemClickListener(this);
	}
	class NewsTask extends AsyncTask<Void, Void, ArrayList<HashMap<String, String>>>
	{

		@Override
		protected ArrayList<HashMap<String, String>> doInBackground(
				Void... params) {
			// TODO Auto-generated method stub
			NewsParser parser = new NewsParser();
			ArrayList<HashMap<String, String>> data = parser.parse(ConstValue.NEWS_URL);
			return data;
			
		}

		@Override
		protected void onCancelled() {
			// TODO Auto-generated method stub
			super.onCancelled();
		}

		@Override
		protected void onPostExecute(ArrayList<HashMap<String, String>> result) {
			// TODO Auto-generated method stub
			setProgressBarVisibility(View.GONE);
			setNewsAdapter(result);
		}

		@Override
		protected void onPreExecute() {
			// TODO Auto-generated method stub
			super.onPreExecute();
		}

		
	}
	
	//---------parser----------//
	class NewsParser extends DefaultHandler {
		protected StringBuilder data;

		private ArrayList<HashMap<String, String>> wineData;
		private HashMap<String, String> record;

		public NewsParser() {
			data = new StringBuilder();
			wineData = new ArrayList<HashMap<String, String>>();
			record = new HashMap<String, String>();
		}

		public ArrayList<HashMap<String, String>> parse(
				String url) {
			DefaultHttpClient client = new DefaultHttpClient();
			HttpGet get = new HttpGet(url);
			get.setHeader("Content-Type", "text/xml; charset:utf-8;");

			try {
				HttpResponse response = client.execute(get);
				if (response.getStatusLine().getStatusCode() == HttpStatus.SC_OK) {
					SAXParser parser = SAXParserFactory.newInstance().newSAXParser();
					InputStream in = response.getEntity().getContent();
					parser.parse(in, this);
				}
			} catch (Exception e) {
				e.printStackTrace();
				wineData = null;
			}
			return wineData;
		}

		@Override
		public void startElement(String uri, String localName, String qName,
				Attributes attributes) throws SAXException {
			data.setLength(0);
			if (localName.equals("item")) {
				record = new HashMap<String, String>();
			}
		}

		@Override
		public void characters(char[] ch, int start, int length)
				throws SAXException {
			data.append(ch, start, length);
		}

		@Override
		public void endElement(String uri, String localName, String qName)
				throws SAXException {
			if (localName.equals("item")) {
				wineData.add(record);
			} else {
				String str = data.toString().replaceAll("&amp;#34;", "\"");
				str = str.replaceAll("&amp;#39;", "'");
				str = str.replaceAll("&amp;#44;", ",");
				str = str.replaceAll("&amp;#45;", "-");
				str = str.replaceAll("Ã©", "é");
				str = str.replaceAll("Ã´", "ô");
				str = str.replaceAll("Ã¼", "ü");
				str = str.replaceAll("Ã±", "ñ");
				str = str.replaceAll("Ã§", "ç");
				str = str.replaceAll("Ã»", "û");
				str = str.replaceAll("Ãª", "ê");
				str = str.replaceAll("Ã¨", "è");
				str = str.replaceAll("Ã£", "ã");
				if(localName.equals("title") || localName.equals("description") || localName.equals("link"))
					record.put(localName, data.toString());
				
				Log.d("title", localName);
				Log.d("val", data.toString());
			}
		}
	}

	// ============================================================
	// Wine Adapter
	// ============================================================
	class NewsAdapter extends BaseAdapter{
		private ArrayList<HashMap<String, String>> data;
	    private LayoutInflater inflater=null;
		public NewsAdapter(Context c,ArrayList<HashMap<String, String>> list)
		{
			data = list;
			inflater = (LayoutInflater)c.getSystemService(Context.LAYOUT_INFLATER_SERVICE);
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
	            vi = inflater.inflate(R.layout.raw_list_item, null);
	        TextView title= (TextView)vi.findViewById(R.id.textTitle);
	        HashMap<String, String> map = data.get(position);
	        title.setText(map.get("title"));
	        return vi;
		}
		
	}

	public void onItemClick(AdapterView<?> parent, View view, int position, long id) {
		// TODO Auto-generated method stub
		Intent intent = new Intent(this,NewsDetails.class);
		//intent.putExtra("position", position);
		ConstValue.SELECTED_NEWS_ID =  position;
		startActivity(intent);
	}
}
