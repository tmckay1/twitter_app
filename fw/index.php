<?php
/**
 * This file parses the url to extract the action to perform for the controller
 */
require_once("../inc/include.php");

//setup variables
$result = array("STATUS" => "OK", "MSG" => "");
$data   = $_GET;

//parse url and extract controller and action
$url        = isset($data['_url']) ? $data['_url'] : "";
$urlArray   = explode("/", $url);
if (count($urlArray) >= 2){
    $action         = end($urlArray);
    $controllerArr  = array_splice($urlArray, 0, count($urlArray) -1 );    
    $controllerBase = implode("\\", $controllerArr);    
    if( strpos($controllerBase, "Controller") === false){
        $controllerBase = $controllerBase . "Controller";
    }else{
		$result["STATUS"] = "ERROR";
		$result["MSG"]    = "Invalid request sent, can't find controller.";
    }
}else{
	$result["STATUS"] = "ERROR";
	$result["MSG"]    = "Invalid request sent.";
}



//initialize controller
$opts           = isset($data['opts']) ? $data['opts'] : null;
$controllerPath = "\Twitter\Controllers".$controllerBase;
$controller     = class_exists($controllerPath) ? new $controllerPath($opts) : new \Twitter\Controllers\BaseController($opts);



//check if the method exists for the given controller
if(method_exists($controller, $action)){
    $result["MSG"] = $controller->$action();
}else if($result["STATUS"] != "ERROR"){
	$result["STATUS"] = "ERROR";
	$result["MSG"]    = "Cannot find specified action ($action) for controller ".get_class($controller).".";
}



//output result
echo json_encode($result);

