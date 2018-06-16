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
		return array(
				INCROOT."/js/twitter/TwitterInclude.js",
				INCROOT."/js/twitter/TwitterTweet.js",
				INCROOT."/js/twitter/TwitterResponse.js",
				INCROOT."/js/twitter/TwitterView.js",
				INCROOT."/js/twitter/TwitterParser.js",
				INCROOT."/js/twitter/TwitterRequest.js",
				INCROOT."/js/index.js",
				INCROOT."/js/home/home.js",
			);
	}

}

