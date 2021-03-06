<?php
namespace Twitter\Controllers\Home;

use \Twitter\Views\Image\Carousel;
use \Twitter\Views\Header\JumboTron;
use \Twitter\Views\Form\Form;
use \Twitter\Views\SingularContentView;

use \Twitter\Auth\Twitter\TwitterAuth;

use \Twitter\Controllers\BaseController;
use \Twitter\Controllers\PageInterface;



/**
 * @class HomeController
 *
 * Controller used to display the home page
 */
class HomeController extends BaseController implements PageInterface{



	/**
	 * Get the contents of the home page
	 *
	 * @return string Controller contents
	 */
	public function getContents(){

		//set carousel background to home page
		$images = array(
						array("class" => "d-block img-fluid", "src" => IMGROOT."/autumn.jpg"),
						array("class" => "d-block img-fluid", "src" => IMGROOT."/blue-sky.jpg"),
						array("class" => "d-block img-fluid", "src" => IMGROOT."/drops-of-water.jpg"),
						array("class" => "d-block img-fluid", "src" => IMGROOT."/apple.jpg"),
						array("class" => "d-block img-fluid", "src" => IMGROOT."/railroad.jpg"),
						array("class" => "d-block img-fluid", "src" => IMGROOT."/heart.jpg"),
					);
		$carousel = new Carousel("carouselSlides", array("images" => $images));
		$carHtml  = $carousel->getView();


		//set gray backdrop
		$grayHtml = "<div class='blur-container'>
				        <img src='".IMGROOT."/solid-gray.png' style='width:100%;height:100%'>
					</div>";

		//get welcome screen
		$jumboAttrs = array(
							"title"    => "Welcome!",
							"subtitle" => "This is the Twitter Web App Project",
							"text"     => $this->auth->isLoggedIn() ? "Post a tweet or search tweets below" : "Search tweets below",
						);
		$jumbotron = new JumboTron("welcomeScreen", $jumboAttrs);
		$jumboView = $jumbotron->getView();
		$jumboHtml = "<div class='row bottom-padding'>
						<div class='col-1'></div>
						<div class='col'>$jumboView</div>
						<div class='col-1'></div>
					</div>";

		//write out the form to post a tweet
		$postTweetHtml = $this->getPostTweetHtml();
		
		//write out form to search twitter api
		$formInputs  = array(
							array(//first row - div to hold any error messages
								array(
										"type"    => "div",
										"options" => array(
															"attributes" => array("id" => "twitter_errorContainer"),
															"content"    => ""
														)
									),
								),
							array(//second row
								array(
										"type"    => "input",
										"label"   => "Search Term",
										"options" => array("type" => "text", "class" => "form-control", "id" => "twitter_searchTerm", "placeholder" => "Search")
									),
								array(
										"type"    => "input",
										"label"   => "Twitter Username",
										"options" => array("type" => "text", "class" => "form-control", "id" => "twitter_username", "placeholder" => "Username")
									),
								),
							array(//third row
								array(
										"type"    => "input",
										"label"   => "Location",
										"options" => array("type" => "text", "class" => "form-control", "id" => "twitter_location", "placeholder" => "New York")
									),
								array(
										"type"    => "select",
										"label"   => "# of Tweets to Display",
										"options" => array(
															"attributes" => array("id" => "twitter_numberOfTweets", "class" => "form-control"),
															"options"    => array(5 => "5", 15 => "15", 25 => "25", 50 => "50", 100 => "100"),
															"content"    => ""
														)
									),
								),
							array(//fourth row
								array(
										"type"    => "input",
										"label"   => "Use My Current Location",
										"options" => array("type" => "checkbox", "class" => "form-check-input", "id" => "twitter_myLocation")
									),
								),
							array(//fifth row
								array(
										"type"    => "button",
										"options" => array(
															"attributes" => array("type" => "submit", "class" => "btn btn-primary", "id" => "twitter_submitButton"),
															"content"    => "Search"
														)
									),
								),
						);
		$formOptions = array(
							"attributes" => array(),
							"content"    => "",
							"inputs"     => $formInputs
						);
		$searchForm  = new Form("twitter_searchForm", $formOptions);
		$searchView  = $searchForm->getView();
		$searchHtml  = "<div class='row bottom-padding'>
							<div class='col'>
								<div class='card' style='width:100%'>
									<div class='card-body'>
										<div class='card-title'>Twitter Search</div>
										<div class='card-text'>$searchView</div>
									</div>
								</div>
							</div>
						</div>";

		//write out the results div
		$loadingOption = array(
								"type"       => "div",
								"content"    => "<div class='row bottom-padding'><div class='col'>".LOADING_ICON."</div></div>",
								"attributes" => array("style" => "display:none;")
							);
		$loadingDiv    = new SingularContentView("twitter_loadingIcon", $loadingOption);
		$resultsOption = array(
								"type"    => "div",
								"content" => "<div class='alert alert-warning' role='alert'>There are currently no search results</div>"
							);
		$resultsDiv  = new SingularContentView("twitter_resultsContainer", $resultsOption);
		$resultsHtml = "<div class='row bottom-padding'>
							<div class='col'>
								<div class='card' style='width:100%'>
									<div class='card-body'>
										<div class='card-title'>Search Results</div>
										<div class='card-text'>".$resultsDiv->getView().$loadingDiv->getView()."</div>
									</div>
								</div>
							</div>
						</div>";


		//write html
		return  $carHtml.$grayHtml.$jumboHtml.$postTweetHtml.$searchHtml.$resultsHtml;
	}



	/**
	 * Get the form to post tweet
	 */
	private function getPostTweetHtml(){

		//if not logged in, do not draw view
		if(!$this->auth->isLoggedIn()){ return "";}

		//write out form to search twitter api
		$formInputs  = array(
							array(//first row - div to hold any error messages
								array(
										"type"    => "div",
										"options" => array(
															"attributes" => array("id" => "twitter_postErrorContainer"),
															"content"    => ""
														)
									),
								),
							array(//second row
								array(
										"type"    => "textarea",
										"label"   => "What do you want the tweet to say?",
										"options" => array(
															"attributes" => array("class" => "form-control", "id" => "twitter_postText", "placeholder" => "Tweet...", "required" => "required"),
															"content"    => ""
														)
									),
								),
							array(//third row
								array(
										"type"    => "button",
										"options" => array(
															"attributes" => array("type" => "submit", "class" => "btn btn-primary", "id" => "twitter_postSubmitButton"),
															"content"    => "Post"
														)
									),
								),
						);
		$formOptions = array(
							"attributes" => array(),
							"content"    => "",
							"inputs"     => $formInputs
						);
		$postTweetForm = new Form("twitter_postTweetForm", $formOptions);
		$postTweetView = $postTweetForm->getView();
		$postTweetHtml =   "<div class='row bottom-padding'>
								<div class='col'>
									<div class='card' style='width:100%'>
										<div class='card-body'>
											<div class='card-title'>Post a Tweet as @".$this->auth->getScreenName()."</div>
											<div class='card-text'>$postTweetView</div>
										</div>
									</div>
								</div>
							</div>
							<br>
							<div class='row bottom-padding'>
								<div class='col-5'><hr></div>
								<div class='col-2' style='text-align:center;color:white'>OR</div>
								<div class='col-5'><hr></div>
							</div>
							<br>";

		return $postTweetHtml;
	}



	/**
	 * Protected accessor used to initialize auth object
	 *
	 * @return \Twitter\Auth\Twitter\TwitterAuth object used for authorization
	 */
	protected function getAuth(){
		return new TwitterAuth();
	}

}
