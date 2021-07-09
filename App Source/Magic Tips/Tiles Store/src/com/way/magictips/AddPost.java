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

public class AddPost extends Activity implements OnClickListener {
	
	@Override
	protected void onCreate(Bundle savedInstanceState) {
		super.onCreate(savedInstanceState);
		setContentView(R.layout.add_post);
		
		findViewById(R.id.btnback).setOnClickListener(this);
		findViewById(R.id.button1).setOnClickListener(this);
		findViewById(R.id.btnNext).setOnClickListener(this);
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
			String pattern = "[a-zA-Z0-9._-]+@[a-z]+\\.+[a-z]+";
			String message = "";
			Boolean ollOk = true;
			
			TextView txtCompany = (TextView)findViewById(R.id.txtCompany);
			String company = txtCompany.getText().toString().trim() ;
			if(company=="")
			{
				message = "Please input Company Name";
			}
			
			TextView txtEmail = (TextView)findViewById(R.id.txtEmail);
			String email = txtEmail.getText().toString().trim();
			if(email=="")
			{
				message = "Please input Email Address";
			}else
			{
				if(email.matches(pattern))
				{
					
				}else
				{
					message = "Please Enter Valide Email Address";
				}
			}
			
			TextView txtWeb = (TextView)findViewById(R.id.txtWeb);
			String web = txtWeb.getText().toString().trim();
			
			if(web!="")
			{
				if(web.matches("^[a-zA-Z0-9\\-\\.]+\\.(com|org|net|mil|edu|COM|ORG|NET|MIL|EDU)$"))
				{
					
				}else
				{
					message = "Please enter valid URL";
				}
			}
			
			if(message!="")
			{
				Toast.makeText(this, message, Toast.LENGTH_LONG ).show();;
			}else
			{
				intent = new Intent(this,AddPost2.class);
				intent.putExtra("company", company);
				intent.putExtra("email", email);
				intent.putExtra("web", web);
			}
			
			break;
		default:
			break;
		}
		
		if(intent!=null){
			startActivity(intent);
			finish();
		}
	}



}
