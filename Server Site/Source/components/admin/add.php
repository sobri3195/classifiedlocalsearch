<?  common::user_access_only("admin");
    if(isset($_POST['submit']))
    {
        validate();
        if(form_validation::validate_fields())
        {
            $username=common::get_control_value("username");
            $password=common::get_control_value("password");
            $email=common::get_control_value("email");
            $active = common::get_control_value("active");
            $type = common::get_control_value("type");
            
            $q = new Query();
            $q->insert_into("user",array("username"=>$username,"password"=>md5($password),"email"=>$email,"active"=>$active,"type"=>$type))
            ->run();
            common::set_message(3);
            common::redirect_to(common::get_component_link(array("admin","add")));
             
        }
    }
?>