/**
 * @class TwitterListView
 *
 * This class builds a list view of tweets
 */
class TwitterListView {



	/**
	 * Default constructor
	 *
	 * @param array tweets Collection of TwitterTweet objects
	 */
	constructor(tweets){
		this.tweets   = tweets;
	}



	/**
	 * Append the list view to a given view
	 *
	 * @param string viewId Id of the view to append the html to
	 */
	appendToView(viewId){

		var view = "";

		//append a row of a single tweet view to our view for each tweet we have
		this.tweets.forEach(function(tweet){
			tweetView = new TwitterCardView(tweet);
			view     += "<div class='row'><div class='col'>" + tweetView.getView() + "</div></div>";
		});
		
		$('#'+viewId).append(view);
	}
}



/**
 * @class TwitterCardView
 *
 * This class builds a card view of a tweet
 */
class TwitterCardView {



	/**
	 * Default constructor
	 *
	 * @param TwitterTweet tweet The tweet object to create a view for
	 */
	constructor(tweet){
		this.tweet = tweet;
	}



	/**
	 * Get the view
	 *
	 * @return string Card View
	 */
	getView(){
		return "";
	}
}


/**
 * @class TwitterEmbededView
 *
 * Represents an embeded view we received from Twitter
 */
class TwitterEmbededView {



	/**
	 * Default constructor
	 *
	 * @param string html The tweet html for this view
	 */
	constructor(html){
		this.html = html;
	}



	/**
	 * Get the embeded view
	 */
	getView(){
		return "<div class='row'><div class='col'>" + this.html + "</div></div>";
	}
}










