<?php
class Credit extends MY_Controller {
	
	private $_name = 'credit';
	 	
	public function index() {
		$this->view->load('content', $this->_name . '/index', array());
		$this->view->set(array());		// TODO add data
		$this->view->render();  
	}
}