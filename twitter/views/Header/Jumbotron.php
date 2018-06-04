<?php
namespace Twitter\Views\Header;

use Twitter\Views\View;



/**
 * @class Jumbotron 
 *
 * Represents a bootstrap jumbotron view
 */
class Jumbotron extends View{




	/**
	 * @var $options Additional options needed to draw our view
	 *
	 * Has format:
	 *  "title"    => string The contents of the title of the jumbotron
	 *  "subtitle" => string The contents of the subtitle of the jumbotron
	 *  "text"     => string The contents of the text directly underneath the title and subtitle     
	 *  "contents" => string Any additional content to add to the view
	 */
	protected $options;



 	/**
 	 * Override the getView to produce a carousel
 	 *
 	 * @return Carousel HTML
 	 */
	public function getView(){

		//define variables
		$title    = isset($this->options['title'])    ? $this->options['title']    : "";
		$subtitle = isset($this->options['subtitle']) ? $this->options['subtitle'] : "";
		$text     = isset($this->options['text'])     ? $this->options['text']     : "";
		$contents = isset($this->options['contents']) ? $this->options['contents'] : "";

		//construnct final view
		$view = "<div id='$this->id' class='jumbotron'>
					<h1 class='display-4'>$title</h1>
					<p class='lead'>$subtitle</p>
					<hr class='my-4' id='hr-$this->id'>
					<p>$text</p>
					$contents
				</div>";

		return $view;
	} 
}