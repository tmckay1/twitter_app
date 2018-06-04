<?php
namespace Twitter\Controllers;



/**
 * @class BaseController
 *
 * This class represents the base class of all the controllers used in this application.
 */
abstract class BaseController {



	/**
	 * Get the contents of the controller
	 *
	 * @return string Controller contents
	 */
	abstract public function getContents();
}