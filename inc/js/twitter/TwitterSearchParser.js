/**
 * @class TwitterSearchParser
 *
 * This class parses the response from a twitter search request
 */
class TwitterSearchParser {



	/**
	 * Default constructor
	 *
	 * @param string response The response from the twitter search
	 */
	constructor(response){
		this.response = response;
	}



	/**
	 * Get the search data from the response
	 *
	 * @return array TwitterTweet Objects
	 */
	getTweets(){

		var tweets = [];

		//make sure we have a valid response with tweets and add them to our return array
		if(this.response && this.response.payload && this.response.payload.statuses){

			var tweetsAlreadyPushed = [];
			this.response.payload.statuses.forEach(function(status){

				//add only unique entries
				if(!tweetsAlreadyPushed.includes(status.text) || (status.text.length >= 2 && status.text.substring(0,2) != "RT")){
					tweetsAlreadyPushed.push(status.text);
					var tweet = new TwitterTweet(status.id_str, status.created_at, status.text);
					tweets.push(tweet);
				}
			});
		}

		return tweets;
	}



	/**
	 * Get any search error that occurred
	 *
	 * @return TwitterSearchError Search error
	 */
	getError(){

		var error = null;

		if(this.response && this.response.error){
			var errorCode = this.response.errorCode ? this.response.errorCode : 0;
			error         = new TwitterSearchError(errorCode, this.response.error);
		}

		return error
	}
}



/**
 * @class TwitterEmbedSearchParser
 *
 * This class parses the response from a twitter embed request
 */
class TwitterEmbedSearchParser {



	/**
	 * Default constructor
	 *
	 * @param string response The response from the twitter search
	 */
	constructor(response){
		this.response = response;
	}



	/**
	 * Get the search data from the response
	 *
	 * @return array TwitterTweet Objects
	 */
	getTweetHtml(){

		//make sure we have a valid response and get html
		var html = this.response && this.response.payload && this.response.payload.html ? this.response.payload.html : "";

		return html;
	}
}











