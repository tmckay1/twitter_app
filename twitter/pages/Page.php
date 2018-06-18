<?php
namespace Twitter\Pages;



/**
 * @class Page
 *
 * This represents a basic page in the app. It has a basic header and footer. This is meant to be 
 * subclassed for the specific page, overriding certain methods indicated below
 */
class Page {



	/**
	 * @var $controller \Twitter\Controller object that will draw the views to the screen
	 */
	protected $controller;

	/**
	 * @var $cssArr Array of css sources to include in the page
	 */
	protected $cssArr;

	/**
	 * @var $jsArr Array of js sources to include in the page
	 */
	protected $jsArr;

	/**
	 * @var $auth \Twitter\Auth\Auth object to perform authentication functions
	 */
	protected $auth;



	/**
	 * Default constructor
	 */
	function __construct(){
		$this->controller = $this->getController();
		$this->auth       = $this->controller->getControllerAuth();
		$this->cssArr     = $this->getCss();
		$this->jsArr      = $this->getJs();
	}



	/**
	 * Draw the contents of the page to the screen
	 */
	final public function drawContents(){

		$this->initializePage();

		$this->authorize();

		$header  = $this->getHeader();
		$content = $this->controller->getContents();
		$footer  = $this->getFooter();

		echo $header.$content.$footer;
	}



	/**
	 * Get the controller 
	 *
	 * @return \Twitter\Controller Controller for the specific page
	 */
	protected function getController(){
		return new \Twitter\Controllers\BaseController();
	}



	/**
	 * Get the css 
	 *
	 * @return array Initialized in the constructor
	 */
	protected function getCss(){
		return array();
	}



	/**
	 * Get the js 
	 *
	 * @return array Initialized in the constructor
	 */
	protected function getJs(){
		return array();
	}



	/**
	 * Get the header
	 *
	 * @return string HTML header for the application
	 */
	private function getHeader(){

		$js  = "";
		$css = "";
		foreach($this->jsArr  as $source){ $js  .= "<script src='$source'></script>";}
		foreach($this->cssArr as $source){ $css .= "<link  href='$source' rel='stylesheet'>";}

		$loginForm = $this->auth->isLoggedIn() ?
									"<form class='form-inline' id='sign-out-form' method='POST'>
										<input type='hidden' name='signout_user' id='signout_user' val='1'>
										<div class='dropdown'>
											<button class='btn btn-outline-info dropdown-toggle' type='button' id='signOutMenuButton' data-toggle='dropdown' aria-haspopup='true' aria-expanded='false'>
												Hello ".$this->auth->getUserName()."
											</button>
											<div class='dropdown-menu' aria-labelledby='signOutMenuButton'>
												<button class='dropdown-item' type='submit' id='signout-user-button'>Sign Out</button>
											</div>
										</div>
									</form>"
									: 
									"<form class='form-inline' id='sign-in-form' method='POST'>
										<input type='hidden' name='signin_user' id='signin_user' val='1'>
										<button class='btn btn-outline-info my-2 my-sm-0' type='submit'>Sign In</button>
									</form>";

		$header =  "<!DOCTYPE html>
					<html>
					    <head>
					        <meta charset='UTF-8'>
					        <meta http-equiv='x-ua-compatible' content='ie=edge'>
					        <meta name='viewport' content='width=device-width, initial-scale=1'>
    						<link  href='".INCROOT."/css/bootstrap.min.css' rel='stylesheet'>
    						<link  href='".INCROOT."/css/index.css' rel='stylesheet'>
    						<script src='".INCROOT."/js/jquery-3.3.1.min.js'></script>
    						<script src='".INCROOT."/js/bootstrap.min.js'></script>
    						$js
    						$css
					    </head>
					    <body>
					        <header class='page-header page-header-sitebrand-topbar' >
					        	<nav class='navbar navbar-light bg-light justify-content-between'>
									<a class='navbar-brand' href='#'><img src='".IMGROOT."/twitter-logo.png'></a>
									$loginForm
								</nav>
					        </header>
					        <div class='container'>";

        return $header;

	}



	/**
	 * Get the footer
	 *
	 * @return string HTML footer for the application
	 */
	private function getFooter(){

		$footer =  "</div>
				</body>
				<footer></footer>
			</html>";

		return $footer;
	}



	/**
	 * Authorize the user (login/logout). Performs action based on POST parameters
	 */
	private function authorize(){

		//log user in if not already logged in
		if(isset($_POST['signin_user']) && !$this->auth->isLoggedIn()){
			$this->auth->login();
		}

		//finish authorizing user if needs special auth
		$this->auth->specialAuthorization();

		//log user in if not already logged in
		if(isset($_POST['signout_user']) && $this->auth->isLoggedIn()){
			$this->auth->logout();
		}
	}



	/**
	 * Perform page initialization functions
	 */
	private function initializePage(){
		global $debugger;
		$debugger->debug($_SESSION);
	}
}