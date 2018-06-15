/**
 * @class TwitterTweet
 *
 * Represents a tweet from twitter
 */
class TwitterTweet {



	/**
	 * Default constructor
	 *
	 * @param string tweetId  The unique id of the tweet
	 * @param string date     The date the tweet was created
	 * @param string tweet    The contents of the tweet itself
	 * @param string handle   The username who sent the tweet
	 */
	constructor(tweetId, date, tweet, handle){
		this.tweetId = tweetId;
		this.date    = date;
		this.tweet   = tweet;
		this.handle  = handle;
	}
}