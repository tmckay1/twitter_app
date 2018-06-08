/**
 * @class TwitterSearchRequest
 *
 * This class encapsulates a search request for the twitter API
 */
class TwitterSearchRequest {



	/**
	 * Default constructor
	 *
	 * @param string username       The username to search for in the API
	 * @param string searchTerm     The term to search for in the API
	 * @param string searchLocation The location to search for in the API
	 * @param int    numberOfTweets The number of tweets to search for in the API
	 */
	constructor(username, searchTerm, searchLocation, numberOfTweets){
		this.username        = username;
		this.searchTerm      = searchTerm;
		this.searchLocation  = searchLocation;   
		this.numberOfTweets  = numberOfTweets;
		this.response        = null;
	}



	/**
	 * Send the search request
	 *
	 * @return TwitterSearchResponse
	 */
	sendRequest(callback){

		//set default response
		var error     = new TwitterSearchError(0, "An unexpected error occurred.");
		this.response = new TwitterSearchResponse(error, null);

		var requestURL  = '/km/fw/index.php';
		var requestData = {
							"username"       : this.username, 
							"searchTerm"     : this.searchTerm, 
							"searchLocation" : this.searchLocation,
							"numberOfTweets" : this.numberOfTweets,
							"path"           : "Twitter",
							"controller"     : "Search",
							"action"         : "searchTwitter"
							};
		$.getJSON(requestURL, requestData, function(data){
			if(data.STATUS == "OK"){
				this.response = new TwitterSearchResponse(null, data.MSG);
			}else{
				error         = new TwitterSearchError(0, data.MSG);
				this.response = new TwitterSearchResponse(error, null);
			}
		}).fail(function(){
			error         = new TwitterSearchError(0, "Failed to send request, no network connection or the server is unavailable at this time.");
			this.response = new TwitterSearchResponse(error, null);
		}).always(function(){
			callback(this.response);
		});
	}
}



/**
 * @class TwitterTweetEmbedRequest
 *
 * This class encapsulates a request to retrieve embeded tweets
 */
class TwitterTweetEmbedRequest {



	/**
	 * Default constructor
	 *
	 * @param TwitterTweet tweet The username to search for in the API
	 */
	constructor(tweet){
		this.tweet = tweet;
	}



	/**
	 * Send the search request
	 *
	 * @return TwitterSearchResponse
	 */
	sendRequest(callback){

		if(!this.tweet.url){
			return;
		}

		//set default response
		var error     = new TwitterSearchError(0, "An unexpected error occurred.");
		this.response = new TwitterSearchResponse(error, null);

		var requestURL  = '/km/fw/index.php';
		var requestData = {
							"path"           : "Twitter",
							"controller"     : "Search",
							"action"         : "getEmbededTweet",
							"url"            : "https://twitter.com/interior/status/507185938620219395"
							};
		$.getJSON(requestURL, requestData, function(data){
			if(data.STATUS == "OK"){
				this.response = new TwitterSearchResponse(null, data.MSG);
			}else{
				error         = new TwitterSearchError(0, data.MSG);
				this.response = new TwitterSearchResponse(error, null);
			}
		}).fail(function(){
			error         = new TwitterSearchError(0, "Failed to send request, no network connection or the server is unavailable at this time.");
			this.response = new TwitterSearchResponse(error, null);
		}).always(function(){
			callback(this.response);
		});
	}
}









