<?php
namespace Twitter\Views\Form;

use \Twitter\Views\SingularContentView;



/**
 * @class SingularContentView 
 *
 * A view with inner contents, and is just on tag (e.g. h1, h2, textarea, div, etc.)
 */
class Select extends SingularContentView {


	
	/**
	 * @var array The values array that contains key => value pointing the value of the option to the option content
	 */
	protected $options;

	/**
	 * @var array The values array that contains key => value pointing the value of the option to the option attributes
	 */
	protected $optionsAttr;



	/**
	 * Override the constructor
	 *
	 * @param string $id      Id of the view
	 * @param array  $options Needed to draw view. Has keys:
	 *                           "options"     => array Options to include with the select
	 *  						 "optionsAttr" => array Options attributes 
	 *
	 */
	function __construct($id, $options = array()){
		parent::__construct($id, $options);
		$this->options     = isset($options['options'])     ? $options['options']     : array();
		$this->optionsAttr = isset($options['optionsAttr']) ? $options['optionsAttr'] : array();
	}



	/**
	 * Override the getView function to draw the singular element with its attributes
	 *
	 * @return string HTML of view
	 */
	public function getView(){

		//create string of attributes for this view
		$attrsHtml = "";
		foreach ($this->attributes as $attribute => $value) { $attrsHtml .= "$attribute='$value' ";}

		//get option content
		$options = "";
		foreach ($this->options as $optionValue => $optionContent) {

			//get attributes (if any)
			$attrs    = (isset($this->optionsAttr[$optionValue]) ? $this->optionsAttr[$optionValue] : array());

			//get attributes html for each option
			$attrHtml = "";
			unset($attrs["value"]);
			if(!empty($attrs)){ foreach($attrs as $attr => $attrValue){ $attrHtml .= "$attr='$attrValue' ";}}

			//get option
			$options .= "<option value='$optionValue' $attrHtml>$optionContent</option>";
		}

		//return view
		return "<$this->tag id='$this->id' $attrsHtml>$options</$this->tag>";
	}

}