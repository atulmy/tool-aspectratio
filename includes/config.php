<?php
	// Application deployment information
	define('DEPLOY_PATH', $_SERVER['DOCUMENT_ROOT'].'/');		//with trailing slash
	define('WEB_URL', 'http://'.$_SERVER['HTTP_HOST'].'/');
	define('STATIC_URL', 'http://'.$_SERVER['HTTP_HOST'].'/static/');
	define('IMAGE_URL', 'http://'.$_SERVER['HTTP_HOST'].'/static/images/');
	define('JS_URL', 'http://'.$_SERVER['HTTP_HOST'].'/static/js/');
	define('CSS_URL', 'http://'.$_SERVER['HTTP_HOST'].'/static/css/');
	
	define('LOG_FILE_FOLDER', 'logs');
	define('LOG_FILE_PATH', DEPLOY_PATH.LOG_FILE_FOLDER.'/');
    
	define('WEBSITE_TITLE', 'Aspect Ratio Calculator');
	define('WEBSITE_VERSION', '0.1');
	define('WEBSITE_VERSION_RELEASE', '&alpha;');
	
	// Databaes related changes
	define("DB1", 1);
	$databases = array();
	$databases[DB1] = array('host'=>'localhost', 'database'=>'aspectratio', 'user'=>'root', 'password'=>'');
	
	// User defined constants
?>