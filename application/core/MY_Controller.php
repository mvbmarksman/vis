<?php
/*
 * http://codeigniter.com/forums/viewthread/84781/
 */
class MY_Controller extends CI_Controller {

	private $_controllerName;

	public function __construct() {
		parent::__construct();
		$this->_controllerName = strtolower(get_class($this));
	}


	/**
	 * Encapsulates rendering of view
	 * @param String $template - refers to the name of the template file
	 * @param mixed $data - what you want to set in the view
	 */
	public function renderView($template, $data) {
		$this->load->library('view');
		$this->view->layout = 'layout';
		$this->view->load('menu', 'common/menu', array());

		$this->view->load('content', $this->_controllerName . '/' . $template, $data);
		$this->view->render();

	}

}