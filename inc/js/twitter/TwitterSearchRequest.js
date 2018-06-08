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
							"path"           : "Home",
							"controller"     : "Home",
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
			error         = new TwitterSearchError(0, "Failed to send request, no network connection.");
			this.response = new TwitterSearchResponse(error, null);
		}).always(function(){
			callback(this.response);
		});
	}
}



/**
 * @class TwitterSearchResponse
 *
 * This class encapulates a search response from the twitter API
 */
class TwitterSearchResponse {



	/**
	 * Default constructor
	 *
	 * @param TwitterSearchError searchError  Error from the response, if any
	 * @param Object             responseData Raw response data
	 */
	constructor(searchError, responseData){
		this.searchError  = searchError;  
		this.responseData = responseData; 
	}
}



/**
 * @class TwitterSearchError
 *
 * Represents an error received from the API
 */
class TwitterSearchError {



	/**
	 * Default constructor
	 *
	 * @param int    errorCode Error code, means nothing for now, can be expanded upon
	 * @param string errorMsg  User friendly message explaining error
	 */
	constructor(errorCode, errorMsg){
		this.errorCode = errorCode;
		this.errorMsg  = errorMsg;
	}
}









