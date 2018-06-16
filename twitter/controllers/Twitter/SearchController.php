<?php
namespace Twitter\Controllers\Twitter;

use \Twitter\Auth\Twitter\TwitterAuth;
use \Twitter\Controllers\BaseController;



/**
 * @class HomeController
 *
 * Controller used to perform twitter search queries
 */
class SearchController extends BaseController {



	/**
	 * @var ERROR_CODE_LOCATION error code for unknown location
	 */
	const ERROR_CODE_UNKNOWN_LOCATION = 3;



	/**
	 * Protected accessor used to initialize auth object
	 *
	 * @return \Twitter\Auth\Twitter\TwitterAuth object used for authorization
	 */
	protected function getAuth(){
		return new TwitterAuth();
	}



	/**
	 * Search Twitter from the GET parameters
	 *
	 * Parameters:
	 *  username         - Username to search for
	 *  searchTerm       - Term to search for
	 *  searchLocation   - Location to search in
	 *  searchMyLocation - Indicates if the user elected to search their current position
	 *  numberOfTweets   - Number of tweets to return
	 *
	 * @return object $statuses The search result
	 */
	public function searchTwitter(){

		//define variables
		$username       = isset($_GET["username"])         ? $_GET["username"]                   : "";
		$searchTerm     = isset($_GET["searchTerm"])       ? $_GET["searchTerm"]                 : "";
		$searchLocation = isset($_GET["searchLocation"])   ? $_GET["searchLocation"]             : array();
		$myLocation     = isset($_GET["searchMyLocation"]) ? $_GET["searchMyLocation"] == "true" : "";
		$numberOfTweets = isset($_GET["numberOfTweets"])   ? $_GET["numberOfTweets"]             : 15;
        $distance       = "10mi";

		//form search parameters
		$searchParams = array();
		if(!empty($username)){       $searchParams['from']    = $username;}
		if(!empty($searchTerm)){     $searchParams['q']       = $searchTerm;}
		if(!empty($numberOfTweets)){ $searchParams['count']   = $numberOfTweets;}

		//get longitude and latitude of location
		if(!empty($myLocation)){     

			//coordinates provided using the user's current location
	        $latitude  = $searchLocation["latitude"];
	        $longitude = $searchLocation["longitude"];
			$searchParams['geocode'] = $latitude.",".$longitude.",".$distance;

		} else if(!empty($searchLocation)){ 

			//need to search google for coordinates
	        $prepAddr  = str_replace(' ','+',$searchLocation);
	        $geocode   = file_get_contents('https://maps.google.com/maps/api/geocode/json?address='.$prepAddr.'&sensor=false');
	        $output    = json_decode($geocode);

	        //failed search
	        if(empty($output) || empty($output->results)){ return array("statuses" => null, "error" => "Could not find specified location.", "errorCode" => self::ERROR_CODE_UNKNOWN_LOCATION);}

	        //successful search
	        $latitude  = $output->results[0]->geometry->location->lat;
	        $longitude = $output->results[0]->geometry->location->lng;
			$searchParams['geocode']  = $latitude.",".$longitude.",".$distance;
		}

		//send request
		$connection = new \Abraham\TwitterOAuth\TwitterOAuth(CONSUMER_KEY, CONSUMER_SECRET, $this->auth->getAuthToken(), $this->auth->getAppSecret());
		$statuses   = $connection->get("search/tweets", $searchParams);

		return array("payload" => $statuses, "error" => null);
	}



	/**
	 * Get the markup for an embedded tweet from the GET parameters
	 *
	 * Parameters:
	 *  url - Url of the tweet to retrieve
	 *
	 * @return object $markup The markup result
	 */
	public function getEmbededTweet(){

		$id = isset($_GET['id']) ? $_GET['id'] : "";

		$connection = new \Abraham\TwitterOAuth\TwitterOAuth(CONSUMER_KEY, CONSUMER_SECRET, $this->auth->getAuthToken(), $this->auth->getAppSecret());
		$statuses   = $connection->get("statuses/oembed", ["id" => $id, "omit_script" => true]);

		return array("payload" => $statuses, "error" => null);
	}

}
