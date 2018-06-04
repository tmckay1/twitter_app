<?php
namespace Twitter\Views;

use \Twitter\Views\View;



/**
 * @class SingularView 
 *
 * A view with no inner contents, just on tag (e.g. input, br, hr, img, etc.)
 */
class SingularView extends View {



	/**
	 * @var string The HTML tag of the element
	 */
	protected $tag;

	/**
	 * @var array The attributes array that contains key => value pointing attribute => attributeValue
	 */
	protected $attributes;



	/**
	 * Override the constructor
	 *
	 * @param string $id      Id of the view
	 * @param array  $options Needed to draw view. Has keys:
	 *                           "attributes" => array  Attribute array, assume there is no id in the array
	 *							 "tag"        => string The HTML tag to draw
	 *
	 */
	function __construct($id, $options = array()){
		parent::__construct($id, $options);
		$this->attributes = isset($options['attributes']) ? $options['attributes'] : array();
		$this->tag        = isset($options['tag'])        ? $options['tag']        : "div";
	}



	/**
	 * Override the getView function to draw the singular element with its attributes
	 *
	 * @return string HTML of view
	 */
	final public function getView(){

		//create string of attributes for this view
		$attrHtml = "";
		foreach ($this->attributes as $attribute => $value) { $attrHtml .= "$attribute='$value' ";}

		//return view
		return "<$this->tag id='$this->id' $attrHtml />";
	}

}