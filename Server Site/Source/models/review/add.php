<?
function validate()
{
        form_validation::add_validation('company', 'required', 'Registration Name');
        form_validation::add_validation('email', 'required', 'Registration email');
        form_validation::add_validation('email', 'email', 'Registration email not valid');
        form_validation::add_validation('title', 'required', 'Registration title');
        form_validation::add_validation('ratting', 'required', 'Registration ratting');
        form_validation::add_validation('review', 'required', 'Registration review');
        
}
?>