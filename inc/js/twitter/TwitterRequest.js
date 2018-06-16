/**
 * @class TwitterRequest
 *
 * This class encapsulates a search request for the twitter API
 */
class TwitterSearchRequest {



	/**
	 * Default constructor
	 *
	 * @param string username         The username to search for in the API
	 * @param string searchTerm       The term to search for in the API
	 * @param string searchLocation   The location to search for in the API
	 * @param bool   searchMyLocation Indicates if we are going to use the user's current position in the search
	 * @param int    numberOfTweets   The number of tweets to search for in the API
	 */
	constructor(username, searchTerm, searchLocation, searchMyLocation, numberOfTweets){
		this.username         = username;
		this.searchTerm       = searchTerm;
		this.searchLocation   = searchLocation;   
		this.numberOfTweets   = numberOfTweets;
		this.searchMyLocation = searchMyLocation;
		this.response         = null;
	}



	/**
	 * Send the search request
	 *
	 * @return TwitterResponse
	 */
	sendRequest(callback){

		//set default response
		var error     = new TwitterError(0, "An unexpected error occurred.");
		this.response = new TwitterResponse(error, null);

		var requestURL  = '/km/fw/Twitter/Search/searchTwitter';
		var requestData = {
							"username"         : this.username, 
							"searchTerm"       : this.searchTerm, 
							"searchLocation"   : this.searchLocation,
							"numberOfTweets"   : this.numberOfTweets,
							"searchMyLocation" : this.searchMyLocation
							};
		$.getJSON(requestURL, requestData, function(data){
			if(data.STATUS == "OK"){
				this.response = new TwitterResponse(null, data.MSG);
			}else{
				error         = new TwitterError(0, data.MSG);
				this.response = new TwitterResponse(error, null);
			}
		}).fail(function(){
			error         = new TwitterError(0, "Failed to send request, no network connection or the server is unavailable at this time.");
			this.response = new TwitterResponse(error, null);
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
	 * @return TwitterResponse
	 */
	sendRequest(callback){

		var tweet = this.tweet;
		if(!tweet.tweetId){ return;}

		//set default response
		var error     = new TwitterError(0, "An unexpected error occurred.");
		this.response = new TwitterResponse(error, null);

		var requestURL  = '/km/fw/Twitter/Search/getEmbededTweet';
		var requestData = {"id": this.tweet.tweetId};
		
		$.getJSON(requestURL, requestData, function(data){
			if(data.STATUS == "OK"){
				this.response = new TwitterResponse(null, data.MSG);
			}else{
				error         = new TwitterError(0, data.MSG);
				this.response = new TwitterResponse(error, null);
			}
		}).fail(function(){
			error         = new TwitterError(0, "Failed to send request, no network connection or the server is unavailable at this time.");
			this.response = new TwitterResponse(error, null);
		}).always(function(){
			callback(this.response, tweet);
		});
	}
}









