<?php
namespace Twitter\Pages;



/**
 * @class Page
 *
 * This represents a basic page in the app. It has a basic header and footer. This is meant to be 
 * subclassed for the specific page, overriding certain methods indicated below. If this was a 
 * real application, authorization and other things can go here
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
	 * Default constructor
	 */
	function __construct(){
		$this->controller = $this->getController();
		$this->cssArr     = $this->getCss();
		$this->jsArr      = $this->getJs();
	}



	/**
	 * Draw the contents of the page to the screen
	 */
	final public function drawContents(){

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
					        <header class='page-header page-header-sitebrand-topbar' ></header>
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
}