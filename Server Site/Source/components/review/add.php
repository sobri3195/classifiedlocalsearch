<?  // header('Content-type: text/json');
$response = array();
    if(isset($_REQUEST['add']))
    {
    
        validate();
        if(form_validation::validate_fields())
        {
          
            $company=common::get_control_value("company");

            $email=common::get_control_value("email");
            $title=common::get_control_value("title");
            $retting=common::get_control_value("ratting");
             $review=common::get_control_value("review");
           
            
            $q=new Query();
            $q->insert_into("reviews",array("title"=>$title,"company"=>$company,"email"=>$email,"ratting"=>$retting,"review"=>$review))
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