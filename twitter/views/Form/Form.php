<?php
namespace Twitter\Views\Form;

use Twitter\Views\SingularView;
use Twitter\Views\SingularContentView;



/**
 * @class Form 
 *
 * Represents an html form. Has options to show form with different inputs
 */
class Form extends SingularContentView{



	/**
	 * @var array The input array that contains an array of key => value:
	 *			  	"type"    => string The tag of input to draw
	 *				"options" => array  Options array for the input containing 'id'
	 *			  	"label"   => string (optional) The label for the input
	 */
	protected $inputs;



	/**
	 * Override the constructor
	 *
	 * @param string $id      Id of the view
	 * @param array  $options Needed to draw view. Has keys:
	 *                           "attributes" => array  Attribute array same as one given in SingularView
	 *                           "content"    => string The inner content of the HTML tag, treated as additional
	 *                           "inputs"     => array  An array of array of input attributes. Assumed each entry
	 *                                                  in this array represents a single row in the form. 
	 *
	 */
	function __construct($id, $options = array()){
		parent::__construct($id, $options);
		$this->inputs = isset($options['inputs']) ? $options['inputs'] : array();
	}



	/**
	 * Override the getView function to draw the form elements with its attributes
	 *
	 * @return string HTML of view
	 */
	public function getView(){

		//create string of attributes for the form
		$attrHtml = "";
		foreach ($this->attributes as $attribute => $value) { $attrHtml .= "$attribute='$value' ";}

		//get input content
		$inputsHtml = "";
		foreach ($this->inputs as $inputRow) {
			
			//draw new row
			$inputsHtml .= "<div class='form-row'>";
			foreach ($inputRow as $inputEntry) {
				
				//draw new column
				$subColumn  = intval(12/count($inputRow));
				$inputsHtml .= "<div class='form-group col-md-$subColumn'>";

				//draw contents
				$type    = isset($inputEntry['type'])    ? $inputEntry['type']    : "input";
				$label   = isset($inputEntry['label'])   ? $inputEntry['label']   : "";
				$options = isset($inputEntry['options']) ? $inputEntry['options'] : array();
				$inputId = isset($options['id'])         ? $options['id']         : "";

				$labelHtml   = !empty($label) ? "<label for='$inputId'>$label</label>" : "";
				$inputHtml   = $this->getInputForTypeAndOptions($type, $options);
				$inputsHtml .= $labelHtml.$inputHtml;

				//close column
				$inputsHtml .= "</div>";
			}

			//close row
			$inputsHtml .= "</div>";
		}

		//return view
		return "<$this->tag id='$this->id' $attrHtml>
					$inputsHtml
					$this->content
				</$this->tag>";
	}



	/**
	 * Get the input for the given type and options
	 *
	 * @param string $type    Type of input to draw (input, select, textarea, etc.)
	 * @param array  $options The options needed for this input, assumed it has 'id' as a key
	 */
	private function getInputForTypeAndOptions($type, $options){

		$inputHtml = "";

		//for not just assume we only have "input" and "button" types so it is quicker
		switch ($type) {
			case "button":
				$id             = isset($options['attributes']) && isset($options['attributes']['id']) ? $options['attributes']['id'] : "";
				if(isset($options['attributes'])){ unset($options['attributes']['id']);}
				$options['tag'] = $type;
				$input          = new SingularContentView($id, $options);
				$inputHtml      = $input->getView();
				break;
			default:
				$id        = isset($options['id']) ? $options['id'] : "";
				unset($options['id']);
				$input     = new SingularView($id, array("attributes" => $options, "tag" => $type));
				$inputHtml = $input->getView();
				break;
		}

		return $inputHtml;		
	}

}