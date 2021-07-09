<?  common::user_access_only();
    if(isset($_GET['id']))
    {
        common::set_session("key",common::get_control_value("id"));    
        common::set_session("company",$q->ge_value("select `company` from `company` where `key`='".common::get_control_value("id")."'"));
    }
    
?>