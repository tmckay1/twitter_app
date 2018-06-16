/**
 * @class TwitterCardView
 *
 * This class builds a card view of a tweet
 */
class TwitterCardView {



	/**
	 * Default constructor
	 *
	 * @param TwitterTweet tweet     The tweet for this view
	 * @param string       tweetHtml The tweet html for this view
	 * @param string       author    The tweet author for this view
	 */
	constructor(tweet, tweetHtml, author){
		this.tweet     = tweet;
		this.tweetHtml = tweetHtml;
		this.author    = author;
	}



	/**
	 * Get the view
	 *
	 * @return string Card View
	 */
	getView(){
		return  "<div id='accordion-"+this.tweet.tweetId+"'>" +
					"<div class='card'>" +
						"<div class='card-header' id='heading-"+this.tweet.tweetId+"'>" +
							"<h5 class='mb-0'>" +
								"<button class='btn btn-link' style='width:100%' data-toggle='collapse' data-target='#collapse-"+this.tweet.tweetId+"' aria-expanded='true' aria-controls='collapse-"+this.tweet.tweetId+"'>" +
								  	"<span style='float:left'>" + this.author + " (@"+this.tweet.handle+")" + "</span>" + 
								  	"<span style='float:right'>" + this.tweet.date + "</span>" +
								  	"<div style='clear:both'></div>" +
								"</button>" +
							"</h5>" +
					    "</div>" +
					    "<div id='collapse-"+this.tweet.tweetId+"' class='collapse show' aria-labelledby='heading-"+this.tweet.tweetId+"' data-parent='#accordion-"+this.tweet.tweetId+"'>" +
							"<div class='card-body'>" +
								this.tweetHtml +
							"</div>" +
				        "</div>" +
				    "</div>" +
			    "</div>";
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
	 * @param TwitterTweet tweet     The tweet for this view
	 * @param string       tweetHtml The tweet html for this view
	 * @param string       author    The tweet author for this view
	 */
	constructor(tweet, tweetHtml, author){
		this.tweet     = tweet;
		this.tweetHtml = tweetHtml;
		this.author    = author;
	}



	/**
	 * Get the embeded view
	 */
	getView(){
		var cardView = new TwitterCardView(this.tweet, this.tweetHtml, this.author);
		return  "<div class='row bottom-padding'>" +
					"<div class='col'>" + 
						cardView.getView() + 
					"</div>" + 
				"</div>";
	}
}










