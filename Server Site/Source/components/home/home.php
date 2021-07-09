<?
    if($_POST['login'])
    {
        $username=common::get_control_value("username");
        $password=common::get_control_value("password");
        $res=common::login_user($username,$password);
        if($res)
        {
            if(common::get_session(ADMIN_LOGIN_TYPE)=="admin")
                common::redirect_to(common::get_component_link(array('user','dashboard')));
            else
                common::redirect_to(common::get_component_link(array('user','dashboard')));
        }else
        {
            echo "user not found";
        }
    }
    if($_POST['register'])
    {
        validate("register");
        if(form_validation::validate_fields())
        {
            $username=common::get_control_value("username");
            $password=common::get_control_value("password");
            $email=common::get_control_value("email");
            
            $q = new Query();
            $q->insert_into("user",array("username"=>$username,"password"=>md5($password),"email"=>$email,"active"=>0,"type"=>"user"))
            ->run();
            common::set_message(3);
            common::redirect_to(common::get_component_link(array("home","home")));
             
        }
            
    }
  
    
 
?>