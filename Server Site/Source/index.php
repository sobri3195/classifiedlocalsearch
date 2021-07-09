<?php
	
	//initialize application with all general libraries
	require_once 'include/general-includes.php';
    
   	if (!defined('DS')) {
		define('DS', DIRECTORY_SEPARATOR);
	}
    if (!defined('WEB_URL')) {
		define('WEB_URL',SITE_URL);
	}
	if (!defined('ROOT')) {
		define('ROOT', dirname(dirname(dirname(__FILE__))));
	}
	if (!defined('APP_DIR')) {
		define('APP_DIR', basename(dirname(dirname(__FILE__))));
	}
	if (!defined('WEBROOT_DIR')) {
		define('WEBROOT_DIR', basename(dirname(__FILE__)));
	}
	if (!defined('WWW_ROOT')) {
		define('WWW_ROOT', dirname(__FILE__) . DS);
	}

   
	//determine the component to be loaded
	$component = common::get_component();
    
    
	//if component is not rendedable go to error document.
	$renderable = common::is_component_renderable($component);
	if ( ! $renderable ) {
		common::redirect_to('index.php?component=error&action=show-error');
		exit();
	}
	
    
    //top code per component
	$component_startup_file = MODEL_DIR . $component[0] . '/' . $component[1] . '.php';
	if ( file_exists($component_startup_file) && is_file($component_startup_file) ) {
		include_once $component_startup_file;
	}
    
    //render component
	$component_file = COMPONENTS_DIR . $component[0] . '/' . $component[1] . '.php';
	if ( file_exists($component_file) && is_file($component_file) ) {
		require_once $component_file;
	}
	
	//top code per component
	$component_startup_file = VIEW_DIR . $component[0] . '/' . $component[1] . '.php';
	if ( file_exists($component_startup_file) && is_file($component_startup_file) ) {
		include_once $component_startup_file;
	}

	//render footer
	
?>