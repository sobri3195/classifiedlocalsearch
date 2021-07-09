<?  common::user_access_only(common::get_session(ADMIN_LOGIN_TYPE));
function validate()
{
        form_validation::add_validation('password', 'required', 'Current Password');
         form_validation::add_validation('password', 'no_space', 'No Space in Current Password');
        
        form_validation::add_validation('newpassword', 'required', 'New Passowrd');
        form_validation::add_validation('newpassword', 'no_space', 'New Passowrd');
}
if($_REQUEST["set"])
{
    validate();
    if(form_validation::validate_fields())
    {
        if(common::change_password(common::get_control_value("password"),common::get_control_value("newpassword")))
        {
            common::set_message(9);
        }else
        {
            common::set_message(8);
        }
    }
}
?>