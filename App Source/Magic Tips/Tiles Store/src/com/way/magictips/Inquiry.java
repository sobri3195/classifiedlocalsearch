package com.way.magictips;

import java.io.IOException;
import java.util.ArrayList;
import java.util.HashMap;





import java.util.List;

import org.apache.http.HttpResponse;
import org.apache.http.NameValuePair;
import org.apache.http.client.ClientProtocolException;
import org.apache.http.client.HttpClient;
import org.apache.http.client.entity.UrlEncodedFormEntity;
import org.apache.http.client.methods.HttpPost;
import org.apache.http.impl.client.DefaultHttpClient;
import org.apache.http.message.BasicNameValuePair;

import com.way.magictrik.R;

import defaultconfig.ConstValue;
import framework.BaseActivity;
import util.common.Util;
import util.imageLoader.ImageLazyLoader;
import util.imageLoader.ImageLoader;
import android.os.Bundle;
import android.app.Activity;
import android.content.Intent;
import android.text.Html;
import android.text.Spanned;
import android.text.util.Linkify;
import android.util.Log;
import android.view.Menu;
import android.view.View;
import android.view.ViewGroup;
import android.view.View.OnClickListener;
import android.widget.Button;
import android.widget.EditText;
import android.widget.ImageView;
import android.widget.TextView;
import android.widget.Toast;

public class Inquiry extends BaseActivity implements OnClickListener {
	TextView txttitle;
	ArrayList<HashMap<String, String>> mCompanyList;
	HashMap<String, String> companyMap;
	String emailAddress;
	EditText txtfullname,txtemail,txtphone,txtcity,txtenquiry;
	Button btnSend,btnclear;
	Spanned message;
	

	@Override
	protected void onCreate(Bundle savedInstanceState) {
		super.onCreate(savedInstanceState);
		setContentView(R.layout.inquiry);
		 Button btnback=(Button)findViewById(R.id.btnback);
	        btnback.setOnClickListener(this);
	        
	        txtfullname = (EditText)findViewById(R.id.editfullName);
		     txtemail = (EditText)findViewById(R.id.editEmail);
		     txtphone = (EditText)findViewById(R.id.editPhone);
		     txtcity = (EditText)findViewById(R.id.editCity);
		     txtenquiry = (EditText)findViewById(R.id.editEnquiry);
		
		txttitle=(TextView)findViewById(R.id.txttitle);
	       
		
		companyMap = (HashMap<String, String>) getIntent().getSerializableExtra("company_detail");
		
		txttitle.setText(companyMap.get("company"));
		
		emailAddress=companyMap.get("email1");
		btnclear=(Button)findViewById(R.id.btnclear);
	     btnclear.setOnClickListener(new OnClickListener() {
			
		
			public void onClick(View v) {
				// TODO Auto-generated method stub
				clearData();
			}
		});
	     
	     btnSend = (Button)findViewById(R.id.btnsend);
	     btnSend.setOnClickListener(new OnClickListener() {
				
				public void onClick(View v) {
					// TODO Auto-generated method stub
					String name = txtfullname.getText().toString();
					String emailtxt = txtemail.getText().toString();
					String phoneno = txtphone.getText().toString();
					String city = txtcity.getText().toString();
					String enquiry = txtenquiry.getText().toString();
					if( name.equalsIgnoreCase("") || emailtxt.equalsIgnoreCase("") || phoneno.equalsIgnoreCase("") || city.equalsIgnoreCase("") || enquiry.equalsIgnoreCase("") /* || accesscode.equalsIgnoreCase("")*/)
					{
						Toast.makeText(getApplicationContext(), "All Fields Required.", 
						         Toast.LENGTH_SHORT).show();
					}else
					{
						String subject = "Enquiry for Products";
						message =Html.fromHtml(new StringBuilder()
					    .append("<p><b>----------Tiles Store Inquiry------------</b></p>")
					    .append("<br><b>" +
					    		"<b>Contact Person :</b>" +txtfullname.getText().toString()+"<br>"+
					    		"<b>Email :</b>" +txtemail.getText().toString()+"<br>"+
					    		"<b>Phone :</b>" +txtphone.getText().toString()+"<br>"+
					    		"<b>City :</b>" +txtcity.getText().toString()+"<br>"+
					    		"<b>Enquiry :</b>" +txtenquiry.getText().toString()
					    		+"<br></b>")
					    		.append("<p></p> <p></p> <span style='font-weight:normal;font-size:10px'> Powered By Tiles Store <br> 8-A National Highway, Real Plaza-1, Lalpar- Morbi -363642</span>")
					    .toString());
						
						
						if(isNetworkAvailable(Inquiry.this))
						{
							
								
								
					    	    HttpClient httpclient = new DefaultHttpClient();
					    	    HttpPost httppost = new HttpPost(ConstValue.JSON_INQUIRY_ADD);

					    	    try {
					    	    	
					    	        // Add your data
					    	        List<NameValuePair> nameValuePairs = new ArrayList<NameValuePair>(2);
					    	        nameValuePairs.add(new BasicNameValuePair("name", txtfullname.getText().toString()));
					    	        nameValuePairs.add(new BasicNameValuePair("company", companyMap.get("id")));
					    	        nameValuePairs.add(new BasicNameValuePair("email", txtemail.getText().toString()));
					    	        nameValuePairs.add(new BasicNameValuePair("phone", txtphone.getText().toString()));
					    	        nameValuePairs.add(new BasicNameValuePair("city", txtcity.getText().toString()));
					    	        nameValuePairs.add(new BasicNameValuePair("message", txtenquiry.getText().toString()));
					    	        nameValuePairs.add(new BasicNameValuePair("add", "yes"));
					     	       
					    	        httppost.setEntity(new UrlEncodedFormEntity(nameValuePairs));

					    	       
					    	        // Execute HTTP Post Request
					    	        HttpResponse response = httpclient.execute(httppost);
					    	        
					    	        if(response.getEntity()!=null)
					    	        {
					    	        	Toast.makeText(Inquiry.this,"Enquiry Send.", Toast.LENGTH_LONG).show();
					    	        
					    	        }
					    	        else
					    	        {
					    	        	Toast.makeText(Inquiry.this,"Fail. to send Enquiry.", Toast.LENGTH_LONG).show();
					    	        	
					    	        }
					    	    } catch (ClientProtocolException e) {
					    	        // TODO Auto-generated catch block
					    	    } catch (IOException e) {
					    	        // TODO Auto-generated catch block
					    	    	Toast.makeText(Inquiry.this,"Fail. Could Not Connect To Server.", Toast.LENGTH_LONG).show();
					    	    	
					    	    }
					    	    
					    	    sendBaseEmail(subject, message, emailAddress);
								clearData();
							
						}
					}
				}
			});
	}

	public void clearData()
	{
		txtfullname.setText("");
	     txtemail.setText("");
	     txtphone.setText("");
	     txtcity.setText("");
	     txtenquiry.setText("");
	}

	public void onClick(View v) {
		// TODO Auto-generated method stub
		switch(v.getId())
		{
		case R.id.btnback:
			finish();
			break;
	
		}
		
	}

}
