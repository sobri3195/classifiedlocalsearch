<?
    function validate()
    {
        form_validation::add_validation('fname', 'required', 'First Name');
        form_validation::add_validation('mname', 'required', 'Middle Name');
        form_validation::add_validation('lname', 'required', 'Last Name');
        form_validation::add_validation('company', 'required', 'Company Name');
        form_validation::add_validation('address', 'required', 'Address');
        form_validation::add_validation('country', 'required', 'Country');
        form_validation::add_validation('state', 'required', 'State');
        form_validation::add_validation('city', 'required', 'City');
        form_validation::add_validation('fname', 'required', 'First Name');
        form_validation::add_validation('zipcode', 'required', 'Zipcode');
        form_validation::add_validation('fname', 'required', 'First Name');
        form_validation::add_validation('phone_country_code', 'required', 'Country Code');
        form_validation::add_validation('phone_area_code', 'required', 'Area Code');
        form_validation::add_validation('phoneno', 'required', 'Phone Number');
        form_validation::add_validation('email', 'required', 'Email Required');
        form_validation::add_validation('email', 'email', 'Email');
        form_validation::add_validation('businesstype', 'required', 'Business Type');
        form_validation::add_validation('category', 'required', 'Category');
        form_validation::add_validation('subcategory', 'required', 'Sub Category');
    }
?>