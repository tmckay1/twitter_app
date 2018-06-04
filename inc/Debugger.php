<?php



/**
 * @class Debugger
 *
 * Class used to debug the application. 
 */
class Debugger{

	

	/**
	 * Debug the given variable if in debug mode
	 *
	 * @param mixed $dbg The variable to debug
	 */
	public function debug($dbg){
		if(DEBUG_MODE){
			var_dump($dbg);
			echo "<br>";
		}
	}
}