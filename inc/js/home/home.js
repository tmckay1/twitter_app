$(document).ready(function(){

	setupTwitterSearchForm();
});



/**
 * Setup form to search twitter API on submit
 */
function setupTwitterSearchForm(){

	$('#twitter_searchForm').on('submit', function(e){

		e.preventDefault();

		//get data needed to search twitter
		var twitter_searchTerm     = $("#twitter_searchTerm").val();
		var twitter_username       = $("#twitter_username").val();
		var twitter_numberOfTweets = $("#twitter_numberOfTweets").val();
		var twitter_location       = $("#twitter_location").val();

		//validate it is filled out, in case the user is tampering
		if(!twitter_searchTerm     || twitter_searchTerm     == ""){ displayError("No search term! Fill out a search term to continue."); return false;}
		if(!twitter_username       || twitter_username       == ""){ displayError("No username! Fill out a twitter username to continue."); return false;}
		if(!twitter_numberOfTweets || twitter_numberOfTweets == ""){ displayError("No number of tweets to display! Fill out the number of tweets to display to continue."); return false;}
		if(!twitter_location       || twitter_location       == ""){ displayError("No location! Fill out the location to search these tweets to continue."); return false;}

		var request  = new TwitterSearchRequest(twitter_username, twitter_searchTerm, twitter_location, twitter_numberOfTweets);
		request.sendRequest(callback);

		return false;
	});
}

var resultsContainerId = "twitter_resultsContainer";

//initialize the callback for the search request
var callback = function(response){ 

	//something is horribly wrong
	if(!response){ displayError("Something went horribly wrong. Please try again later. Sorry."); return false;}

	//check response
	if(response.searchError){ displayError(response.searchError.errorMsg); return false;}

	//parse raw data
	var parser   = new TwitterSearchParser(response.responseData);
	var tweets   = parser.getTweets();

	//handle response by filling in the view
	$('#'+resultsContainerId).html();
	tweets.forEach(function(tweet){
		var embedRequest = new TwitterTweetEmbedRequest(tweet);
		embedRequest.sendRequest(embedCallback);
	});

	console.log(tweets);
}

//initialize the callback for the embed request
var embedCallback = function(response){

	//something is horribly wrong
	if(!response){ displayError("Something went horribly wrong. Please try again later. Sorry."); return false;}

	//check response
	if(response.searchError){ displayError(response.searchError.errorMsg); return false;}

	//parse the raw data and append the view to our existing view
	var parser    = new TwitterEmbedSearchParser(response.responseData);
	var tweetHtml = parser.getTweetHtml();
	var embededView = new TwitterEmbededView(tweetHtml);
	$('#'+resultsContainerId).append(embededView.getView());

	//initialize embed
	twttr.widgets.load(document.getElementById("#"+resultsContainerId));
}



/**
 * Display the error message to the screen
 */
function displayError(errorMsg){

	//generate error div
	var alert = '<div class="alert alert-danger" role="alert">'+errorMsg+'</div>';

	$("#twitter_errorContainer").html(alert).show().delay(3000).fadeOut();
}