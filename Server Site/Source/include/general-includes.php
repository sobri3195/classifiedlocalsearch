<?php
	session_start();
	//error_reporting(E_ALL ^ E_WARNING ^ E_NOTICE);
	require_once dirname(__FILE__).'/global-declarations.php';
	require_once dirname(__FILE__).'/../class/clsconnection.php';
	require_once dirname(__FILE__).'/../class/clsquery.php';
    require_once dirname(__FILE__).'/../class/clscommon.php';
	require_once dirname(__FILE__).'/../class/clsform-validation.php';
	require_once dirname(__FILE__).'/../class/clspaging-sorting.php';
    require_once dirname(__FILE__).'/../class/excel_reader2.php';
	require_once dirname(__FILE__).'/../class/clscsvparse.php';
    require_once dirname(__FILE__).'/../class/mail/class.phpmailer.php';
    require_once dirname(__FILE__).'/../class/clsimagefun.php';
    
            
    //require_once COMPONENTS_DIR . 'menu/class/clsmenu.php';
	
    connection::open_connection();
	$q=new Query();
    //$menu = new menu();
?>