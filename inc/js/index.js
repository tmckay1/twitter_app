/**
 * @page index.js
 *
 * This page controls basic functions used by almost every page in the application
 */



/**
 * Display the error message to the screen
 *
 * @param string alertClass  The class of the alert to display (e.g. danger, warning, info, etc.)
 * @param string errorMsg    The message to display
 * @param string containerId The container that will house the message
 */
function displayAlert(alertClass, errorMsg, containerId){

	//generate error div
	var alert = '<div class="alert alert-' + alertClass + '" role="alert">'+errorMsg+'</div>';

	$("#"+containerId).html(alert).show().delay(3000).fadeOut();
}



/**
 * Display the error message to the screen
 *
 * @param string errorMsg    The message to display
 * @param string containerId The container that will house the message
 */
function displayError(errorMsg, containerId){
	displayAlert("danger", errorMsg, containerId);
}



/**
 * Display the warning message to the screen
 *
 * @param string errorMsg    The message to display
 * @param string containerId The container that will house the message
 */
function displayWarning(errorMsg, containerId){
	displayAlert("warning", errorMsg, containerId);
}



/**
 * Display the warning message to the screen
 *
 * @param string errorMsg    The message to display
 * @param string containerId The container that will house the message
 */
function displayInfo(errorMsg, containerId){
	displayAlert("info", errorMsg, containerId);
}



/**
 * Get the location of the user using HTML5 Geolocation
 *
 * @param function callback The callback to use when successfully retrieved user's location
 *
 * @return bool Indicates if the browser supports geolocation
 */
function getLocation(callback) {
    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(callback);
        return true;
    }
    return false;
}


