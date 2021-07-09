<?  common::user_access_only("admin");
common::load_model("user","add");
    $q=new Query();
    $q->select()
    ->from("user")
    ->where_equal_to(array("id"=>common::get_control_value("id")))
    ->limit(1)
    ->run()
    ;

    $data=$q->get_selected();
    
    if(isset($_POST['submit']))
    {
        validate();
        if(form_validation::validate_fields())
        {
            $username=common::get_control_value("username");
            $password=common::get_control_value("password");
            if($password!=common::get_control_value("temppassword"))
                $password = md5($password);
                
            $email=common::get_control_value("email");
            $active = common::get_control_value("active");
            $type = common::get_control_value("type");
            
            $q = new Query();
            $q->update("user",array("username"=>$username,"password"=>$password,"email"=>$email,"active"=>$active,"type"=>$type))
            ->where_equal_to(array("id"=>common::get_control_value("id")))
            ->run();
            common::set_message(3);
            common::redirect_to(common::get_component_link(array("user","add")));
             
        }
    }
?>