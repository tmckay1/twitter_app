<?php
/**
 * This page should be redone to create a .htaccess file that will forbid entry to anything in the fw/ folder and 
 * redirect here. Then we would parse the path to extract the controller and action. For the sake of time, this 
 * will do for now.
 */
require_once("../inc/include.php");

//setup variables
$result = array("STATUS" => "OK", "MSG" => "");
$data   = $_GET;

//check if we have required parameters
$requiredFields    = array("controller", "path", "action");
$hasRequiredFields = true;
foreach($requiredFields as $field){
	if(!isset($data[$field])){
		$hasRequiredFields = false;
		break;
	}
}

//check required fields
if($hasRequiredFields){

	$controller = $data['controller'];
	$path       = $data['path'];
	$action     = $data['action'];

	//check if controller exists
	$controllerPath = "\\Twitter\\Controllers\\$path\\{$controller}Controller";
	if(class_exists($controllerPath)){

		//check if method exists
		$controller = new $controllerPath();
		if(method_exists($controller, $action)){
			$result["MSG"] = $controller->$action();
		}else{
			$result["STATUS"] = "ERROR";
			$result["MSG"]    = "Cannot find specified action.";
		}
	}else{
		$result["STATUS"] = "ERROR";
		$result["MSG"]    = "Cannot find specified controller.";
	}
}else{
	$result["STATUS"] = "ERROR";
	$result["MSG"]    = "Invalid request sent.";
}

echo json_encode($result);

