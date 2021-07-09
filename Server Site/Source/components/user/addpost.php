<?
if(isset($_POST["add"]))
{       common::load_model("user","dashboard");
        validate();
        if(form_validation::validate_fields())
        {
            $imgfun=new imagecomponent();
            $name = common::get_control_value("name");
            $address =  common::get_control_value("address");
            $phone1 = common::get_control_value("phone1");
            $email1 =  common::get_control_value("email1");
            $city =  common::get_control_value("city");
            $state =  common::get_control_value("state");
            $website =  common::get_control_value("website");
            $category=  $_REQUEST["category"];
            $fax = common::get_control_value("fax");
            $zip = common::get_control_value("zip");
                
            $q=new Query();
            $q->insert_into("company",array("company"=>$name,"category"=>$category[0],"email1"=>$email1,"fax"=>$fax,"address"=>$address,"city"=>$city,"state"=>$state,"website"=>$website,"zip"=>$zip,"phone1"=>$phone1))

             ->run();    
            
            $id = $q->get_insert_id();
            foreach($category as $cat){
            $q = new Query();
            $q->insert_into("relation",array("company"=>$id,"category"=>$cat))
            ->run();
            }
            
            echo "success";
        }else
        {
            echo "field validation error";
        }
    
}
?>