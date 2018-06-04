<?php
namespace Twitter\Views;



/**
 * @class View 
 *
 * Represents a generic html view
 */
abstract class View {



	/**
	 * @var $id The id of the view
	 */
	protected $id;

	/**
	 * @var $options Additional options for the view
	 */
	protected $options;



	/**
	 * Default constructor
	 *
	 * @param string $id      Id of the view
	 * @param array  $options Any additional options needed for this view
	 */
	function __construct($id, $options = array()){
		$this->id      = $id;
		$this->options = $options;
	}



	/**
	 * Get the HTML for the view
	 *
	 * @return string View html
	 */
	abstract public function getView();

}