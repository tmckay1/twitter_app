<?php
namespace Twitter\Auth\Twitter;

use \Twitter\Auth\Auth;

use \Twitter\Controllers\Twitter\AuthorizationController;
use \Twitter\Controllers\Twitter\UserController;



/**
 * @class TwitterAuth
 *
 * This class authenticates the user and performs authorziation functions using the Twitter API
 */
class TwitterAuth extends Auth{



	/**
	 * @var TWITTER_AUTH_KEY_BASE The base key entry that points to all Twitter auth entries
	 */
	const TWITTER_AUTH_KEY_BASE         = "twitter_auth";

	/**
	 * @var TWITTER_AUTH_KEY_LOGGED_IN Key pointing to a boolean indicating if the user authenticated into Twitter using this app
	 */
	const TWITTER_AUTH_KEY_LOGGED_IN    = "twitter_user_logged_in";

	/**
	 * @var TWITTER_AUTH_KEY_OAUTH_TOKEN Key pointing to the oauth token retreived from the initial request token
	 */
	const TWITTER_AUTH_KEY_OAUTH_TOKEN  = "twitter_oauth_token";

	/**
	 * @var TWITTER_AUTH_KEY_OAUTH_SECRET Key pointing to the oauth secret retrieved from the initial request token
	 */
	const TWITTER_AUTH_KEY_OAUTH_SECRET = "twitter_oauth_secret";

	/**
	 * @var TWITTER_AUTH_KEY_ACCESS_TOKEN Key pointing to the access token retrieved from a successful authentication
	 */
	const TWITTER_AUTH_KEY_ACCESS_TOKEN = "twitter_access_token";

	/**
	 * @var TWITTER_AUTH_KEY_USER_NAME Key pointing to the full name of the user
	 */
	const TWITTER_AUTH_KEY_USER_NAME    = "twitter_user_name";

	/**
	 * @var TWITTER_AUTH_KEY_SCREEN_NAME Key pointing to the screen name of the user
	 */
	const TWITTER_AUTH_KEY_SCREEN_NAME  = "twiiter_screen_name";



	/**
	 * Check if a user is logged in
	 */
	public function isLoggedIn(){
		return isset($_SESSION[self::TWITTER_AUTH_KEY_BASE]) && isset($_SESSION[self::TWITTER_AUTH_KEY_BASE][self::TWITTER_AUTH_KEY_LOGGED_IN]) && $_SESSION[self::TWITTER_AUTH_KEY_BASE][self::TWITTER_AUTH_KEY_LOGGED_IN] == true;
	}



	/**
	 * Login the user
	 */
	public function login(){

		global $debugger;

		$controller = new AuthorizationController();

		//get request token
		$requestToken = $controller->getRequestToken();
		$debugger->debug($requestToken);

		//store auth token
		$_SESSION[self::TWITTER_AUTH_KEY_BASE][self::TWITTER_AUTH_KEY_OAUTH_TOKEN]  = $requestToken['request_token']['oauth_token'];
		$_SESSION[self::TWITTER_AUTH_KEY_BASE][self::TWITTER_AUTH_KEY_OAUTH_SECRET] = $requestToken['request_token']['oauth_token_secret'];

		//get url which we will use to redirect so we can log into twitter
		$controller->authorizeUser($requestToken['request_token']['oauth_token']);
	}



	/**
	 * Finish up authorization from oauth
	 */
	public function specialAuthorization(){

		global $debugger;

		//only continue if we are finishing the oauth process
		if(!isset($_SESSION[self::TWITTER_AUTH_KEY_BASE]) || (isset($_SESSION[self::TWITTER_AUTH_KEY_BASE][self::TWITTER_AUTH_KEY_LOGGED_IN]) && $_SESSION[self::TWITTER_AUTH_KEY_BASE][self::TWITTER_AUTH_KEY_LOGGED_IN]) || !isset($_REQUEST['oauth_verifier'])){ return;}

		//verify the request token we have is the same we got back (so there is no tampering)
		$requestToken = array();
		$requestToken['oauth_token']        = $_SESSION[self::TWITTER_AUTH_KEY_BASE][self::TWITTER_AUTH_KEY_OAUTH_TOKEN];
		$requestToken['oauth_token_secret'] = $_SESSION[self::TWITTER_AUTH_KEY_BASE][self::TWITTER_AUTH_KEY_OAUTH_SECRET];

		if (isset($_REQUEST['oauth_token']) && $requestToken['oauth_token'] !== $_REQUEST['oauth_token']) {
			// Abort! Something is wrong. For not just return, decide what to do later
			return;
		}

		//get access token and store it
		$controller  = new AuthorizationController();
		$accessToken = $controller->getAccessToken($requestToken);
		$_SESSION[self::TWITTER_AUTH_KEY_BASE][self::TWITTER_AUTH_KEY_ACCESS_TOKEN] = $accessToken['access_token'];

		//get profile details
		$controller  = new UserController(); 
		$profileData = $controller->getProfileData();
		$_SESSION[self::TWITTER_AUTH_KEY_BASE][self::TWITTER_AUTH_KEY_USER_NAME]   = $profileData['profile_data']->name;
		$_SESSION[self::TWITTER_AUTH_KEY_BASE][self::TWITTER_AUTH_KEY_SCREEN_NAME] = $profileData['profile_data']->screen_name;

		//login the user
		$_SESSION[self::TWITTER_AUTH_KEY_BASE][self::TWITTER_AUTH_KEY_LOGGED_IN] = true;

		$debugger->debug($_SESSION);
	}



	/**
	 * Logout the user
	 */
	public function logout(){

		//reset all the session variables related to this auth
		unset($_SESSION[self::TWITTER_AUTH_KEY_BASE]);
	}



	/**
	 * Get the authorization token 
	 */
	public function getAuthToken(){
		return isset($_SESSION[self::TWITTER_AUTH_KEY_BASE]) && isset($_SESSION[self::TWITTER_AUTH_KEY_BASE][self::TWITTER_AUTH_KEY_ACCESS_TOKEN]) ? $_SESSION[self::TWITTER_AUTH_KEY_BASE][self::TWITTER_AUTH_KEY_ACCESS_TOKEN]["oauth_token"] : APP_ACCESS_TOKEN;
	}



	/**
	 * Get the authorization secret
	 */
	public function getAppSecret(){
		return isset($_SESSION[self::TWITTER_AUTH_KEY_BASE]) && isset($_SESSION[self::TWITTER_AUTH_KEY_BASE][self::TWITTER_AUTH_KEY_ACCESS_TOKEN]) ? $_SESSION[self::TWITTER_AUTH_KEY_BASE][self::TWITTER_AUTH_KEY_ACCESS_TOKEN]["oauth_token_secret"] : APP_ACCESS_TOKEN_SECRET;
	}



	/**
	 * Get the username of the logged in user
	 */
	public function getUserName(){
		return isset($_SESSION[self::TWITTER_AUTH_KEY_BASE]) && isset($_SESSION[self::TWITTER_AUTH_KEY_BASE][self::TWITTER_AUTH_KEY_USER_NAME]) ? $_SESSION[self::TWITTER_AUTH_KEY_BASE][self::TWITTER_AUTH_KEY_USER_NAME] : "";
	}



	/**
	 * Get the screen name of the logged in user
	 */
	public function getScreenName(){
		return isset($_SESSION[self::TWITTER_AUTH_KEY_BASE]) && isset($_SESSION[self::TWITTER_AUTH_KEY_BASE][self::TWITTER_AUTH_KEY_SCREEN_NAME]) ? $_SESSION[self::TWITTER_AUTH_KEY_BASE][self::TWITTER_AUTH_KEY_SCREEN_NAME] : "";
	}
}