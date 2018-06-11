$(document).ready(function(){
	setupTwitterSearchForm();
	getLocation();
});


//define callbacks and variables
var resultsContainerId = "twitter_resultsContainer";

var latitude  = "";
var longitude = "";

//initialize the callback for the search request
var searchCallback = function(response){ 

	toggleLoadingIcon(false);

	//something is horribly wrong
	if(!response){ displayError("Something went horribly wrong. Please try again later. Sorry."); return false;}

	//check response
	if(response.searchError){ displayError(response.searchError.errorMsg); return false;}

	//parse raw data
	var parser   = new TwitterSearchParser(response.responseData);
	var tweets   = parser.getTweets();

	//handle response by filling in the view
	if(tweets.length){
		$('#'+resultsContainerId).html("");
		tweets.forEach(function(tweet){
			var embedRequest = new TwitterTweetEmbedRequest(tweet);
			embedRequest.sendRequest(embedCallback);
		});
	}else{
		displayError("Your search did not turn up any results, please refine your search.");
	}

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
		if((!twitter_searchTerm    || twitter_searchTerm     == "") && (!twitter_username || twitter_username == "")){ displayError("No search term or username! Fill out a search term or username to continue."); return false;}
		if(!twitter_numberOfTweets || twitter_numberOfTweets == ""){ displayError("No number of tweets to display! Select the number of tweets to display to continue."); return false;}

		toggleLoadingIcon(true);
		var request  = new TwitterSearchRequest(twitter_username, twitter_searchTerm, twitter_location, twitter_myLocation, twitter_numberOfTweets);
		request.sendRequest(searchCallback);

		return false;
	});
}



/**
 * Display the error message to the screen
 */
function displayError(errorMsg){

	//generate error div
	var alert = '<div class="alert alert-danger" role="alert">'+errorMsg+'</div>';

	$("#twitter_errorContainer").html(alert).show().delay(3000).fadeOut();
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


function getLocation() {

	$("#twitter_myLocation").closest(".form-row").hide();

    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(showPosition);
    } else {
        alert("Geolocation is not supported by this browser.");
    }
}
function showPosition(position) {
	$("#twitter_myLocation").closest(".form-row").fadeIn();
	latitude  = position.coords.latitude;
	longitude = position.coords.longitude;
}


