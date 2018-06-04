<?php
namespace Twitter\Views;

use \Twitter\Views\View;



/**
 * @class SingularContentView 
 *
 * A view with inner contents, and is just on tag (e.g. h1, h2, textarea, div, etc.)
 */
class SingularContentView extends View {


	
	/**
	 * @var array The attributes array that contains key => value pointing attribute => attributeValue
	 */
	protected $attributes;

	/**
	 * @var string The HTML tag of the element
	 */
	protected $tag;

	/**
	 * @var string The inner contents of the tag
	 */
	protected $content;



	/**
	 * Override the constructor
	 *
	 * @param string $id      Id of the view
	 * @param array  $options Needed to draw view. Has keys:
	 *                           "attributes" => array  Attribute array same as one given in SingularView
	 *                           "content"    => string The inner content of the HTML tag
	 *							 "tag"        => string The HTML tag to draw
	 *
	 */
	function __construct($id, $options = array()){
		parent::__construct($id, $options);
		$this->attributes = isset($options['attributes']) ? $options['attributes'] : array();
		$this->tag        = isset($options['tag'])        ? $options['tag']        : "div";
		$this->content    = isset($options['content'])    ? $options['content']    : "";
	}



	/**
	 * Override the getView function to draw the singular element with its attributes
	 *
	 * @return string HTML of view
	 */
	public function getView(){

		//create string of attributes for this view
		$attrHtml = "";
		foreach ($this->attributes as $attribute => $value) { $attrHtml .= "$attribute='$value' ";}

		//return view
		return "<$this->tag id='$this->id' $attrHtml>$this->content</$this->tag>";
	}

}