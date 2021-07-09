<?

$logoimage="";
$bannerimage = "";
if(isset($_POST["add"]))
{
        validate();
        if(form_validation::validate_fields())
        {
            $imgfun=new imagecomponent();
            $name = common::get_control_value("name");
            $address =  common::get_control_value("address");
            $lat =  common::get_control_value("lat");
            $log =  common::get_control_value("log");
            $phone1 = common::get_control_value("phone1");
            $phone2 =  common::get_control_value("phone2");
            $person1 =  common::get_control_value("person1");
            $person2 =  common::get_control_value("person2");
            $email1 =  common::get_control_value("email1");
            $email2 =  common::get_control_value("email2");
            $content =  common::get_control_value("content");
            $android =  common::get_control_value("android");
            $iphone =  common::get_control_value("iphone");
            $city =  common::get_control_value("city");
            $state =  common::get_control_value("state");
            $website =  common::get_control_value("website");
            $category=  $_REQUEST["category"];
            $fax = common::get_control_value("fax");
            $zip = common::get_control_value("zip");
            $logoimage = common::get_control_value("logoimg");
            $bannerimage = common::get_control_value("bannerimg");
            $order = common::get_control_value("order");
            
            $status = common::get_control_value("status");
            if($status){ $status = 1; }else{ $status = 0; }
            $gold = common::get_control_value("gold");
            if($gold){ $gold = 1; }else{ $gold = 0; }
            $varified = common::get_control_value("varified");
            if($varified){ $varified = 1; }else{ $varified = 0; }
           
           
            if($_FILES['featureimage']['size']>0)                
                $logoimage=$imgfun->upload_image_and_thumbnail('featureimage',500,200,'userfiles','contents',false);
             if($_FILES['bannerimage ']['size']>0)                
                $bannerimage =$imgfun->upload_image_and_thumbnail('bannerimage ',320,100,'userfiles','contents',false);    
            $q=new Query();
            $q->insert_into("company",array("company"=>$name,"category"=>$category[0],"email1"=>$email1,"email2"=>$email2,"fax"=>$fax,"address"=>$address,"city"=>$city,"state"=>$state,"website"=>$website," 	key_person1"=>$person1,
            "key_person2"=>$person2,"zip"=>$zip,"phone1"=>$phone1,"phone2"=>$phone2,"logo"=>$logoimage["imagename"],"banner"=>$bannerimage["imagename"],"status"=>'1',"content"=>$content,"longitude"=>$log,"latitude"=>$lat,"android"=>$android,"iphone"=>$iphone,"status"=>$status,"special"=>$gold,"top"=>$varified,"`order`"=>$order))

             ->run();        
            
            $id = $q->get_insert_id();
            foreach($category as $cat){
            $q = new Query();
            $q->insert_into("relation",array("company"=>$id,"category"=>$cat))
            ->run();
            }
            
            common::set_message(3);
            common::redirect_to(common::get_component_link(array("company","register")));
        }
    
}
?>