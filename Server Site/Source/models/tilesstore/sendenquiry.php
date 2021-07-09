<?
    function validate()
    {
        form_validation::add_validation('name', 'required', 'Name');
        form_validation::add_validation('email', 'required', 'Email');
        form_validation::add_validation('email', 'email', 'Email');
        form_validation::add_validation('company', 'required', 'Company');
        form_validation::add_validation('phone', 'required', 'Phone');
        form_validation::add_validation('subject', 'required', 'subject');
        form_validation::add_validation('message', 'required', 'Message');
        
        
    }
?>