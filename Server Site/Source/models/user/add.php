<?
function validate()
{
        form_validation::add_validation('username', 'required', 'Registration Name');
         form_validation::add_validation('username', 'no_space', 'Registration Name');
        form_validation::add_validation('email', 'required', 'Registration email');
        form_validation::add_validation('email', 'email', 'Registration email not valid');
        form_validation::add_validation('password', 'required', 'Registration Passowrd');
        form_validation::add_validation('password', 'no_space', 'Registration Passowrd');
}
?>