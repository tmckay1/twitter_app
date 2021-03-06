$(document).ready(function(){
	setupTwitterSearchForm();
	setupTwitterPostStatusForm();
	setupLoadMoreTweets();
	setupLocation();
});


//define callbacks and variables
var resultsContainerId = "twitter_resultsContainer";

var latitude  = ""; //latitude  of user's location (if we are allowed access)
var longitude = ""; //longitude of user's location (if we are allowed access)

//store tweet search response in an array and keep track of the tweets displayed
var tweets                   = [];
var tweetsToDisplayAtOneTime = 5;
var tweetIndexToDisplay      = 0;
var canResendEmbedRequest    = false;

//sometimes google api fails, so keep track of last request and retry certain number of times
var lastSearchRequest = null;
var retryAttempts     = 5;
var numberOfRetries   = 0;

//initialize the callback for the search request
var searchCallback = function(response){ 

	toggleLoadingIcon(false);
	numberOfRetries++;

	//something is horribly wrong
	if(!response){ displayError("Something went horribly wrong. Please try again later. Sorry.", "twitter_errorContainer"); return false;}

	//check response
	if(response.searchError){ displayError(response.searchError.errorMsg, "twitter_errorContainer"); return false;}

	//parse raw data
	var parser = new TwitterSearchParser(response.responseData);
	tweets     = parser.getTweets();
	var error  = parser.getError();
	tweetIndexToDisplay = 0;

	//handle response by filling in the view
	if(error){
		if(error.getLocationErrorCode() == error.errorCode && numberOfRetries < retryAttempts && lastSearchRequest){ //retry request if could not find location
			lastSearchRequest.sendRequest(searchCallback);
		}else{
			numberOfRetries = 0;
			displayError(error.errorMsg, "twitter_errorContainer");
		}
	}else{
		if(tweets.length != $("#twitter_numberOfTweets").val()){
			displayWarning("Only "+tweets.length+" tweets were found matching your search criteria.");
		}
		numberOfRetries = 0;
		displayMoreTweets();
	}
}

//initialize the callback for the embed request
var embedCallback = function(response, tweet){

	$("#twitter_loadingIcon").hide();
	canResendEmbedRequest = true;

	//something is horribly wrong
	if(!response){ displayError("Something went horribly wrong. Please try again later. Sorry.", "twitter_errorContainer"); return false;}

	//check response
	if(response.searchError){ displayError(response.searchError.errorMsg, "twitter_errorContainer"); return false;}

	//parse the raw data and append the view to our existing view
	var parser      = new TwitterEmbedSearchParser(response.responseData);
	var tweetHtml   = parser.getTweetHtml();
	var author      = parser.getAuthor();
	var embededView = new TwitterEmbededView(tweet, tweetHtml, author);
	$('#'+resultsContainerId).append(embededView.getView());

	//initialize embed
	twttr.widgets.load(document.getElementById("#"+resultsContainerId));
}

//initialize callback for posting a status
var postStatusCallback = function(response){

	togglePostFormButton(false);

	//something is horribly wrong
	if(!response){ displayError("Something went horribly wrong. Please try again later. Sorry.", "twitter_postErrorContainer"); return false;}

	//check response
	if(response.searchError){ displayError(response.searchError.errorMsg, "twitter_postErrorContainer"); return false;}

	//display success and clear contents of tweet
	displaySuccess("Status successfully updated! Search for your tweets below.", "twitter_postErrorContainer");
	$("#twitter_postText").val("");
}

//initialize callback for getting the user's position
var storePosition = function(position) {
	$("#twitter_myLocation").closest(".form-row").fadeIn();
	latitude  = position.coords.latitude;
	longitude = position.coords.longitude;
}



/**
 * Setup form to post a status through the twitter API
 */
function setupTwitterPostStatusForm(){

	$('#twitter_postTweetForm').on('submit', function(e){

		e.preventDefault();

		//get data needed to search twitter
		var twitter_postText = $("#twitter_postText").val();
		
		//validate it is filled out, in case the user is tampering
		if(!twitter_postText || twitter_postText == ""){ displayError("No tweet entered! Enter a tweet below to continue.", "twitter_postErrorContainer"); return false;}

		togglePostFormButton(true);
		var request = new TwitterPostStatusRequest(twitter_postText);
		request.sendRequest(postStatusCallback);

		return false;
	});
}



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
		var twitter_location       = $("#twitter_myLocation").prop('checked') ? {"latitude": latitude, "longitude": longitude} : $("#twitter_location").val();
		var twitter_myLocation     = $("#twitter_myLocation").prop('checked');
		
		//validate it is filled out, in case the user is tampering
		if((!twitter_searchTerm    || twitter_searchTerm     == "") && (!twitter_username || twitter_username == "")){ displayError("No search term or username! Fill out a search term or username to continue.", "twitter_errorContainer"); return false;}
		if(!twitter_numberOfTweets || twitter_numberOfTweets == ""){ displayError("No number of tweets to display! Select the number of tweets to display to continue.", "twitter_errorContainer"); return false;}

		toggleLoadingIcon(true);
		var request       = new TwitterSearchRequest(twitter_username, twitter_searchTerm, twitter_location, twitter_myLocation, twitter_numberOfTweets);
		lastSearchRequest = request;
		request.sendRequest(searchCallback);

		return false;
	});
}



/**
 * Show/hide the loadingIcon
 */
function toggleLoadingIcon(show){

	var icon      = $("#twitter_loadingIcon");
	var results   = $("#"+resultsContainerId);
	var searchBtn = $("#twitter_submitButton");

	if(show){ 
		icon.show();
		results.hide();
		searchBtn.attr("disabled", "disabled");
		searchBtn.html("Searching...");
	}else{ 
		icon.hide();
		results.show();
		searchBtn.removeAttr("disabled");
		searchBtn.html("Search");
	}
}



/**
 * Modify UI to show status is posting
 */
function togglePostFormButton(show){

	var postBtn = $("#twitter_postSubmitButton");

	if(show){ 
		postBtn.attr("disabled", "disabled");
		postBtn.html("Posting...");
	}else{ 
		postBtn.removeAttr("disabled");
		postBtn.html("Post");
	}
}



/**
 * When we scroll to the bottom of the screen, load more tweets if there are any to load
 */
function setupLoadMoreTweets(){
	window.onscroll = function(ev) { //hit bottom of screen
	    if ((window.innerHeight + window.scrollY) >= document.body.offsetHeight) {
	    	if(tweets.length && canResendEmbedRequest){
	    		console.log("display");
				displayMoreTweets();
		    }
	    }
	};
}



/**
 * Display tweets to the page if there are any left that haven't yet been displayed
 */
function displayMoreTweets(){

	if(tweets.length){

		//display tweets only if there is any more to display
		if(tweetIndexToDisplay < tweets.length){

			//hide contents of results if the first time
			if(tweetIndexToDisplay == 0){
				$('#'+resultsContainerId).html("");
			}

			canResendEmbedRequest = false;
			$("#twitter_loadingIcon").show();

			//loop through the tweets to display and send the request
			var endTweetIndex = tweets.length < tweetIndexToDisplay + tweetsToDisplayAtOneTime ? tweets.length : tweetIndexToDisplay + tweetsToDisplayAtOneTime; 
			for(var i=tweetIndexToDisplay; i<endTweetIndex; i++){
				var tweet        = tweets[i];
				var embedRequest = new TwitterTweetEmbedRequest(tweet);
				embedRequest.sendRequest(embedCallback);
			}

			//reset tweet index
			tweetIndexToDisplay += tweetsToDisplayAtOneTime;
		}
	}else{
		displayError("Your search did not turn up any results, please refine your search.", "twitter_errorContainer");
	}
}



/**
 * Location functions
 */
function setupLocation(){

	//uncheck and hide the checkbox
	$("#twitter_myLocation").prop('checked', false);
	$("#twitter_myLocation").closest(".form-row").hide();

	//disable location input if mylocation checked
	$("#twitter_myLocation").on('change', function(e){
		var locationInput = $("#twitter_location");
		if($(this).prop('checked')){
			locationInput.attr('disabled','disabled');
		}else{
			locationInput.removeAttr('disabled');
		}
	});

	//get the user's location
	getLocation(storePosition);
}


