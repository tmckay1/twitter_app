<?php
namespace Twitter\Controllers\Twitter;

use \Twitter\Auth\Twitter\TwitterAuth;
use \Twitter\Controllers\BaseController;

use \Abraham\TwitterOAuth\TwitterOAuth;



/**
 * @class UserController
 *
 * Controller used to perform actions to the Twitter API involving the user 
 */
class UserController extends BaseController {



	/**
	 * @var $connection Connection used to authorize Twitter users
	 */
	protected $connection;



	/**
	 * Initialize the controller
	 */
	function __construct(){
		parent::__construct();
		$this->connection = new TwitterOAuth(CONSUMER_KEY, CONSUMER_SECRET, $this->auth->getAuthToken(), $this->auth->getAppSecret());
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
	 * Get the profile data for the user
	 *
	 * @return array The profile data
	 */
	public function getProfileData(){

		$profileData = $this->connection->get('account/verify_credentials', array('tweet_mode' => 'extended', 'include_entities' => 'true'));

		return array("profile_data" => $profileData, "http_code" => $this->connection->getLastHttpCode());
	}
}
