<?php
namespace Twitter\Controllers\Twitter;

use \Twitter\Controllers\BaseController;



/**
 * @class HomeController
 *
 * Controller used to perform twitter search queries
 */
class SearchController extends BaseController {



	/**
	 * Get empty contents
	 *
	 * @return string Controller contents
	 */
	public function getContents(){
		return "";
	}


	/**
	 * Search Twitter from the GET parameters
	 *
	 * Parameters:
	 *  username       - Username to search for
	 *  searchTerm     - Term to search for
	 *  searchLocation - Location to search in
	 *  numberOfTweets - Number of tweets to return
	 *
	 * @return object $statuses The search result
	 */
	public function searchTwitter(){

		$connection = new \Abraham\TwitterOAuth\TwitterOAuth(CONSUMER_KEY, CONSUMER_SECRET, APP_ACCESS_TOKEN, APP_ACCESS_TOKEN_SECRET);
		$statuses   = $connection->get("search/tweets", ["from" => "realDonaldTrump"]);

		return $statuses;
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

		$url = $_GET['url'];

		$connection = new \Abraham\TwitterOAuth\TwitterOAuth(CONSUMER_KEY, CONSUMER_SECRET, APP_ACCESS_TOKEN, APP_ACCESS_TOKEN_SECRET);
		$statuses   = $connection->get("statuses/oembed", ["url" => $url, "omit_script" => true]);

		return $statuses;

	}

}
