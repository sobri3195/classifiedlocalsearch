package com.way.magictips;

import java.util.HashMap;
import com.way.magictrik.R;
import defaultconfig.ConstValue;
import framework.BaseActivity;
import android.net.Uri;
import android.os.Bundle;
import android.app.Activity;
import android.content.Intent;
import android.view.Menu;
import android.view.View;
import android.view.View.OnClickListener;
import android.widget.Button;
import android.widget.TextView;

public class NewsDetails extends BaseActivity {
	String position;
	Button btnreadmore;
	String link;
	@Override
	protected void onCreate(Bundle savedInstanceState) {
		super.onCreate(savedInstanceState);
		setContentView(R.layout.news_details);
		Bundle bundle = getIntent().getExtras();
		
		
		HashMap<String, String> map = new HashMap<String, String>();
		map = ConstValue.newsList.get(ConstValue.SELECTED_NEWS_ID);
		TextView texttitle = (TextView)findViewById(R.id.textTitle);
		TextView textDesc = (TextView)findViewById(R.id.textDescription);
		
		texttitle.setText(map.get("title"));
		textDesc.setText(html2text(map.get("description")));
		btnreadmore = (Button)findViewById(R.id.button2);
		link = map.get("link");
		btnreadmore.setOnClickListener(new OnClickListener() {
			
			public void onClick(View v) {
				// TODO Auto-generated method stub
				Intent intent = new Intent(Intent.ACTION_VIEW, Uri.parse(link));
				startActivity(intent);
			}
		});
	}

	@Override
	public boolean onCreateOptionsMenu(Menu menu) {
		// Inflate the menu; this adds items to the action bar if it is present.
		getMenuInflater().inflate(R.menu.home, menu);
		return true;
	}

}
