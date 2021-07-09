<?php

	

	define('DIRECT_ACCESS', true);
	define('HOST','localhost');
	define('DATABASE','magic');
	define('USERNAME','root');
	define('PASSWORD','');

	define('DB_PREFIX','');

	/*---------Mail Config--------------*/
    define('SMTP_SERVER','mail.tilesstore.in');
    define('SMTP_USER',"info@tilesstore.in");
    define('SMTP_PASSWORD',"info@123");
    /*---------Mail Config--------------*/
    

	define('COMPANY_NAME','WAY WEB SOLUTION');
    define('COMPANY_EMAIL',"info@tilesstore.in");
	define('COPY_RIGHT_SENTENCE', '&copy; 2011-12 waywebsolution.com');

	define('PAGE_TITLE', 'waywebsolution.com - welcome to admin panel');

	

	define('REQUIRED','<span class="required">*</span>');

	define('REQUIRED_SENTENCE', '(' . REQUIRED . ' = Mandatory)');

	

	define('DEFAULT_PAGE_SIZE', 15);

	

	define('SESSION_PREFIX','tkawy_session_');

	define('ADMIN_LOGIN_USER_ID','AccessToken');
    define('ADMIN_LOGIN_USER_NAME','UserName');
    define('ADMIN_LOGIN_TYPE','UserType');
    define('ADMIN_KEY',"key");
    define('ADMIN_COMPANY',"company");
    
    define('ADMIN_LOGIN_USER_ID_COOKIE','AccessTokenCookie');
	define('ADMIN_LOGIN_USER_NAME_COOKIE','UserNameCookie');
    define('ADMIN_LOGIN_TYPE_COOKIE','UserTypeCookie');
    
	define('ADMIN_LOGIN_USER_TYPE_ID','admin_login_user_type_id');

	define('USER_ID','user_id');

	define('MESSAGE_SESSION', 'message_session');

	

	define('DATE_SEPARATOR','-');

	

	define('NO_OF_DECIMAL_POINT', 2);

	

	define('SEO_ENABLED', true);

	

	define('ADMIN_THEME', 'themes/admin/');
    define('DEFAULT_THEME', 'themes/default/');
	

	define('ADMIN_PATH', 'admin/');
	define('COMPONENTS_DIR', 'components/');
    define('VIEW_DIR', 'views/');
    define('MODEL_DIR', 'models/');
    define('ELEMENT_DIR', 'elements/');
	define('COMPONENTS_INCLUDE_DIR', 'include/');
	define('MYSQL_DATE_FORMAT', '%d-%m-%Y');
	define('MYSQL_DATE_FORMAT2', '%M %d, %Y');

	define('SITE_URL', 'http://localhost/magictrik/');

	

?>