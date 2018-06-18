<?php
namespace Twitter\Controllers\Twitter;

use \Twitter\Controllers\BaseController;

use \Abraham\TwitterOAuth\TwitterOAuth;



/**
 * @class AuthorizationController
 *
 * Controller used to authenticate through twitter
 */
class AuthorizationController extends BaseController {



	/**
	 * @var $connection Connection used to authorize Twitter users
	 */
	protected $connection;



	/**
	 * Initialize the controller
	 */
	function __construct(){
		$this->connection = new TwitterOAuth(CONSUMER_KEY, CONSUMER_SECRET);
	}



	/**
	 * Protected accessor used to initialize auth object
	 *
	 * @return \Twitter\Auth\Twitter\TwitterAuth object used for authorization
	 */
	protected function getAuth(){
		return new TwitterAuth();
	}



	/**
	 * Get the request token to authorize the user
	 *
	 * @return array The request token to use to login
	 */
	public function getRequestToken(){

		$requestToken = $this->connection->oauth('oauth/request_token');

		return array("request_token" => $requestToken, "http_code" => $this->connection->getLastHttpCode());
	}



	/**
	 * Get the access token for the given request token
	 */
	public function getAccessToken($requestToken){

		//setup new connection with request tokens we got from Twitter
		$connection = new TwitterOAuth(CONSUMER_KEY, CONSUMER_SECRET, $requestToken['oauth_token'], $requestToken['oauth_token_secret']);
		$accessToken = $connection->oauth("oauth/access_token", array("oauth_verifier" => $_REQUEST['oauth_verifier']));

		return array("access_token" => $accessToken, "http_code" => $connection->getLastHttpCode());
	}



	/**
	 * Authorize the user with the given request token
	 *
	 * @param string $oauthToken The token used to authorize the user
	 */
	public function authorizeUser($oauthToken){
		$url = $this->connection->url('oauth/authorize', array('oauth_token' => $oauthToken));
		header("location: $url");
	}
}
