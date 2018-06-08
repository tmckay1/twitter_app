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

		//initialize the request and callback 
		var callback = function(response){ 

			//something is horribly wrong
			if(!response){ displayError("Something went horribly wrong. Please try again later. Sorry."); return false;}

			//check response
			if(response.searchError){ displayError(response.searchError.errorMsg); return false;}

			//parse raw data and handle response
			var parser = new TwitterSearchParser(response.responseData);
			var tweets = parser.getTweets();

			console.log(tweets);
		}
		var request  = new TwitterSearchRequest(twitter_username, twitter_searchTerm, twitter_location, twitter_numberOfTweets);
		request.sendRequest(callback);

		return false;
	});
}

function displayError(errorMsg){

	//generate error div
	var alert = '<div class="alert alert-danger" role="alert">'+errorMsg+'</div>';

	$("#twitter_errorContainer").html(alert).show().delay(3000).fadeOut();
}