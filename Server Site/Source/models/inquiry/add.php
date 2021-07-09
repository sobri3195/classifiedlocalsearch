<?
function validate()
{
        form_validation::add_validation('company', 'required', 'Registration Name');
        form_validation::add_validation('email', 'required', 'Registration email');
        form_validation::add_validation('email', 'email', 'Registration email not valid');
        form_validation::add_validation('name', 'required', 'Registration Name');
        form_validation::add_validation('city', 'required', 'Registration City');
        form_validation::add_validation('message', 'required', 'Registration Message');
        
}
?>