<?php

//turn on error reporting
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

//define constants
define("WEBROOT","http://".$_SERVER['SERVER_NAME'].'/km');
define("INCROOT", WEBROOT.'/inc');
define("IMGROOT", INCROOT.'/img');
define("LOADING_ICON", "<img src='".IMGROOT."/loading.gif' style='display:block;margin: 0 auto;'>");
define("DOCROOT", $_SERVER['DOCUMENT_ROOT'].'/km');
if(isset($_GET['dbg'])){
	define("DEBUG_MODE",1);
}else{
	define("DEBUG_MODE",0);
}

//setup config
require DOCROOT . '/inc/config.php';

//setup vendor
require DOCROOT . '/twitter/vendor/autoload.php';

// Setup auto load for load the class files without manually include file by file.
require DOCROOT . '/inc/vendor/Autoload.php';
$Autoload = new \Vendor\Autoload();
$Autoload->register();
$Autoload->addNamespace('Twitter', DOCROOT . '/twitter');
unset($Autoload);

//setup debugger
require DOCROOT . '/inc/Debugger.php';
$debugger = new Debugger();