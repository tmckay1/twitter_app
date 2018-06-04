<?php
namespace Twitter\Pages\Home;

use \Twitter\Pages\Page;



/**
 * @class HomePage
 *
 * Class representing the home page
 */
class HomePage extends Page{



	/**
	 * Get the controller 
	 *
	 * @return \Twitter\Controller Home page controller
	 */
	protected function getController(){
		return new \Twitter\Controllers\Home\HomeController();
	}



	/**
	 * Get the css 
	 *
	 * @return array Initialized in the constructor
	 */
	protected function getCss(){
		return array(
				INCROOT."/css/home/home.css"
			);
	}



	/**
	 * Get the js 
	 *
	 * @return array Initialized in the constructor
	 */
	protected function getJs(){
		return array();
	}

}

