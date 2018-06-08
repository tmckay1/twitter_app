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
		if(this.response && this.response.statuses){
			this.response.statuses.forEach(function(status){
				var url   = status.entities && status.entities.urls && status.entities.urls.length > 0 && status.entities.urls[0].url ? status.entities.urls[0].url : "";
				var tweet = new TwitterTweet(status.id, status.created_at, status.text, url);
				tweets.push(tweet);
			});
		}

		return tweets;
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
		var html = this.response && this.response.html ? this.response.html : "";

		return html;
	}
}











