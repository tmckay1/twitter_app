<?php
namespace Twitter\Controllers\Home;

use \Twitter\Views\Image\Carousel;
use \Twitter\Views\Header\JumboTron;
use \Twitter\Views\Form\Form;

use \Twitter\Controllers\BaseController;



/**
 * @class HomeController
 *
 * Controller used to display the home page
 */
class HomeController extends BaseController {



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
							"text"     => "Search tweets below",
						);
		$jumbotron = new JumboTron("welcomeScreen", $jumboAttrs);
		$jumboView = $jumbotron->getView();
		$jumboHtml = "<div class='row bottom-padding'>
						<div class='col-1'></div>
						<div class='col'>$jumboView</div>
						<div class='col-1'></div>
					</div>";

		//write out form to search twitter api
		$formInputs  = array(
							array(//first row
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
							array(//second row
								array(
										"type"    => "input",
										"label"   => "# of Tweets to Display",
										"options" => array("type" => "text", "class" => "form-control", "id" => "twitter_numberOfTweets", "placeholder" => "25")
									),
								array(
										"type"    => "input",
										"label"   => "Location",
										"options" => array("type" => "text", "class" => "form-control", "id" => "twitter_location", "placeholder" => "New York")
									),
								),
							array(//third row
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
		$searchHtml  = "<div class='row'>
							<div class='card' style='width:100%'>
								<div class='card-body'>
									<div class='card-title'>Twitter Search</div>
									<div class='card-text'>$searchView</div>
								</div>
							</div>
						</div>";

		//write html
		return  $carHtml.$grayHtml.$jumboHtml.$searchHtml;
	}

}
