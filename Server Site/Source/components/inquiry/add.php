<?  // header('Content-type: text/json');
$response = array();
    if(isset($_REQUEST['add']) && $_REQUEST["add"]=="yes")
    {
    
        validate();
        if(form_validation::validate_fields())
        {
          
            $company=common::get_control_value("company");

            $email=common::get_control_value("email");
            $name=common::get_control_value("name");
            
            $phone=common::get_control_value("phone");
            
            $city=common::get_control_value("city");
            $message = common::get_control_value("message");
            
           
            
            $q=new Query();
            $q->insert_into("enquries",array("name"=>$name,"company_id"=>$company,"email"=>$email,"phone"=>$phone,"city"=>$city,"message"=>$message,"date"=>date('Y-m-d H:i:s')))
            ->run();
          $response ["response"] = array("success"=>"review added successfully");

        }else
        {
                  $response ["response"] = array("error"=>"error in add record");
        }
    }
 //    echo json_encode($response);
     ?>
       <?// if ( common::do_show_message() ) {
	//	          echo common::show_message();	
          //  } ?> 