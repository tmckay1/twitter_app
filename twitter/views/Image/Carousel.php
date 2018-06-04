<?php
namespace Twitter\Views\Image;

use Twitter\Views\View;
use Twitter\Views\SingularView;


/**
 * @class Carousel 
 *
 * Represents a bootstrap carousel view
 */
class Carousel extends View{



	/**
	 * @var $images Array of image info that can be used to initialize an Image object. To be the images in the carousel
	 */
	protected $images;



	/**
	 * Override the constructor to set our images
	 *
	 * @param string $id Id of the view
	 * @param array  $options array containing info for the view. The "images" option should point to an array of image info
	 */
	function __construct($id, $options = array()){
		parent::__construct($id, $options);
		$this->images = isset($options["images"]) ? $options["images"] : array();
 	}



 	/**
 	 * Override the getView to produce a carousel
 	 *
 	 * @return Carousel HTML
 	 */
	public function getView(){

		//loop through images and create slide html for carousel
		$slides = "";
		for($i=0; $i<count($this->images); $i++){

			//create image view from image info
			$imageInfo = $this->images[$i];
			$active    = $i == 0 ? "active" : "";
			$image     = new SingularView("img_$i", array("attributes" => $imageInfo, "tag" => "img"));
			$imgHtml   = $image->getView();

			//put image in carrousel
			$slides .= "<div class='carousel-item $active'>
					        $imgHtml
					    </div>";
		}

		//construnct final view
		$view = "<div class='carousel-container'>
					<div id='$this->id' class='carousel slide' data-ride='carousel'>
						<div class='carousel-inner' role='listbox'>
							$slides
						</div>
					</div>
				</div>";

		return $view;
	} 
}