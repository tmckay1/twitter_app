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
	 * @param string tweet   The contents of the tweet itself
	 * @param string url     The tweet url
	 */
	constructor(tweetId, date, tweet, url){
		this.tweetId = tweetId;
		this.date    = date;
		this.tweet   = tweet;
		this.url     = url;
	}
}