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
				var tweet = new TwitterTweet(status.id, status.created_at, status.text);
				tweets.push(tweet);
			});
		}

		return tweets;
	}
}



/**
 * @class TwitterTweet
 *
 * Represents a tweet from twitter
 */
class TwitterTweet {



	/**
	 * Default constructor
	 *
	 * @param string tweetId The unique id of the tweet
	 * @param string date    The date the tweet was created
	 * @param string tweet   The tweet itself
	 */
	constructor(tweetId, date, tweet){
		this.tweetId = tweetId;
		this.date    = date;
		this.tweet   = tweet;
	}
}











