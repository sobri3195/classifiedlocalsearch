package com.way.magictips;

import com.way.magictrik.R;
import com.way.magictrik.R.id;
import com.way.magictrik.R.layout;
import com.way.magictrik.R.menu;

import android.support.v7.app.ActionBarActivity;
import android.annotation.SuppressLint;
import android.app.Activity;
import android.content.Intent;
import android.os.Bundle;
import android.view.Menu;
import android.view.MenuItem;
import android.view.View;
import android.view.View.OnClickListener;
import android.widget.Button;
import android.widget.TextView;
import android.widget.Toast;

public class AddPost2 extends Activity implements OnClickListener {

	String company,email,web;
	@Override
	protected void onCreate(Bundle savedInstanceState) {
		super.onCreate(savedInstanceState);
		setContentView(R.layout.activity_add_post2);
		
		findViewById(R.id.btnback).setOnClickListener(this);
		findViewById(R.id.button1).setOnClickListener(this);
		findViewById(R.id.btnNext).setOnClickListener(this);
		
		Bundle b = getIntent().getExtras();
		company = b.getString("company");
		email = b.getString("email");
		web = b.getString("web");
		
		
	}

	
	@SuppressLint("NewApi")
	public void onClick(View v) {
		// TODO Auto-generated method stub
		Intent intent = null;
		switch (v.getId()) {
		case R.id.btnback:
			finish();
			break;
		case R.id.button1:
			finish();
			break;	
		case R.id.btnNext:
			String message = "";
			TextView txtCity = (TextView)findViewById(R.id.txtCity);
			String city = txtCity.getText().toString().trim();
			if(city=="")
			{
				message = "Please enter city";
			}
			
			TextView txtState = (TextView)findViewById(R.id.txtState);
			String state = txtState.getText().toString().trim();
			if(state=="")
			{
				message = "Please enter State";
			}
			
			TextView txtZip = (TextView)findViewById(R.id.txtZip);
			String zip = txtZip.getText().toString().trim();
			if(zip=="")
			{
				message = "Please enter Zip";
			}
			TextView txtPhone = (TextView)findViewById(R.id.txtPhone);
			String phone = txtPhone.getText().toString().trim();
			if(phone=="")
			{
				message = "Please enter Phone";
			}
			TextView txtAddress = (TextView)findViewById(R.id.txtAddress);
			String address = txtAddress.getText().toString().trim();
			if(address=="")
			{
				message = "Please enter Phone";
			}
			
			if(message=="")
			{
				intent = new Intent(this,AddPost3.class);
				intent.putExtra("company",company);
				intent.putExtra("email",email);
				intent.putExtra("web",web);
				intent.putExtra("city",city);
				intent.putExtra("state",state);
				intent.putExtra("zip",zip);
				intent.putExtra("phone",phone);
				intent.putExtra("address",address);
				
			}else
			{
				Toast.makeText(this, message, Toast.LENGTH_LONG).show();
			}
			
			break;
		default:
			break;
			
			
		}
		if (intent!=null) {
			startActivity(intent);
			finish();
		}
	}

	
}
