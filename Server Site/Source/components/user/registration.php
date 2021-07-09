<? common::user_access_only();
 $q->select()
    ->from('categories')
    ->run()
    ;
    $cat=$q->get_selected();
       
 if(isset($_POST['submit']))
 {
    validate();
    if(form_validation::validate_fields())
    {
        $fname=common::get_control_value('fname');
        $mname=common::get_control_value('mname');
        $lname=common::get_control_value('lname');
        $company=common::get_control_value('company');
        $weburl=preg_replace("/[^a-zA-Z0-9._]/", "",common::get_control_value('tempurl'));
        $address=common::get_control_value('address');
        $country=common::get_control_value('country');
        $state=common::get_control_value('state');
        $city=common::get_control_value('city');
        $zip=common::get_control_value('zipcode');
        $ph_c_code=common::get_control_value('phone_country_code');
        $ph_a_code=common::get_control_value('phone_area_code');
        $phno=common::get_control_value('phoneno');
        $email=common::get_control_value('email');
        $btype=common::get_control_value('businesstype');
        $category=common::get_control_value('category');
        $subcategory=common::get_control_value('subcategory');
        $regdate=date('Y-m-d h:i:s');
        $regid=$ccode=common::get_unique_code('GE'+md5($regdate),28);
        
        $insert=array(
        "Reg_ID"=>$regid,
        "Fname"=>$fname,
        "Mname"=>$mname,
        "Lname"=>$lname,
        "Company"=>$company,
        "web_url"=>$weburl,
        "Address"=>$address,
        "Country"=>$country,
        "State"=>$state,
        "City"=>$city,
        "Zipcode"=>$zip,
        "Ph_count_code"=>$ph_c_code,
        "Ph_area_code"=>$ph_a_code,
        "Phoneno"=>$phno,
        "Email"=>$email,
        "business_type"=>$btype,
        "category"=>$category,
        "subcategory"=>$subcategory,
        "Reg_Date"=>$regdate,
        "Reg_IP"=>$_SERVER['REMOTE_ADDR'],
        "acl"=>'0'
        );
        $q->insert('customer_details',$insert)
        ->run()
        ;
        
        $sent=common::send_mail(array($email,$fname.' '.$lname),"Your Registration to Gujaratxpress","thanx for making registration in gujaratxpress");
        if($sent)
        {
            common::redirect_to(common::get_component_link(array('user','regconf')));
        }
    }
  }    
?>