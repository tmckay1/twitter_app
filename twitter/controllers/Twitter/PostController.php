<?php
namespace Twitter\Controllers\Twitter;

use \Twitter\Auth\Twitter\TwitterAuth;
use \Twitter\Controllers\BaseController;

use \Abraham\TwitterOAuth\TwitterOAuth;



/**
 * @class PostController
 *
 * Controller used to perform actions to the Twitter API involving the posting data 
 */
class PostController extends BaseController {



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
	 * Post a text status for the user using the GET parameters
	 *
	 * Parameters:
	 *  status - Status to post
	 *
	 * @return array The statuses
	 */
	public function postStatus(){

		$status = isset($_GET['status']) ? $_GET['status'] : "";

		$statuses = $this->connection->post("statuses/update", array("status" => $status));

		return array("payload" => $statuses);
	}
}
