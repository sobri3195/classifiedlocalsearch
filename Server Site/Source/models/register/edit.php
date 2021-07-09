<?
    function validate()
    {
       form_validation::add_validation('name', 'required', 'Registration Name');
        form_validation::add_validation('category', 'required', 'Registration Category');
        form_validation::add_validation('email', 'required', 'Registration email');
        form_validation::add_validation('email', 'email', 'Registration email not valid');
        form_validation::add_validation('address', 'required', 'Registration Address');
        form_validation::add_validation('city', 'required', 'Registration city');
        form_validation::add_validation('zip', 'required', 'Registration zip');
        form_validation::add_validation('phoneno', 'required', 'Registration Phoneno');
        
    }
?>