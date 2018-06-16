<?php
namespace Twitter\Controllers;



/**
 * @interface PageInterface
 *
 * The interface used by some controllers that draw contents to a page
 */
interface PageInterface {



	/**
	 * Get the contents of the controller
	 *
	 * @return string Controller contents
	 */
	public function getContents();
}



/**
 * @class BaseController
 *
 * This class represents the base class of all the controllers used in this application.
 */
abstract class BaseController {



	/**
	 * @var $auth \Twitter\Auth\Auth object that validates the page
	 */
	protected $auth;



	/**
	 * Initialize this controller with an authorization object
	 */
	function __construct(){
		$this->auth = $this->getAuth();
	}
	


	/**
	 * Protected accessor used to initialize auth object
	 *
	 * @return \Twitter\Auth\Auth object used for authorization
	 */
	abstract protected function getAuth();



	/**
	 * Public accessor to this controller's authorization object
	 *
	 * @return \Twitter\Auth\Auth object used for authorization
	 */
	public function getControllerAuth(){
		return $this->auth;
	}
}