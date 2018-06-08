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
		this.tweets = tweets;
	}



	/**
	 * Get the view
	 *
	 * @return string List View
	 */
	getView(){

		var view = "";

		//append a row of a single tweet view to our view for each tweet we have
		this.tweets.forEach(function(tweet){
			var tweetView = new TwitterCardView(tweet);
			view += "<div class='row'><div class='col'>" + tweetView.getView() + "</div></div>";
		});

		return view;
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
		this.tweets = tweets;
	}



	/**
	 * Get the view
	 *
	 * @return string Card View
	 */
	getView(){

		var view = "";


		return view;
	}
}










