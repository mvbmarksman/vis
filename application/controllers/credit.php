<?php
class Credit extends MY_Controller {
	
	private $_name = 'credit';
	 	
	public function index() {
		$this->view->load('content', $this->_name . '/index', array());
		$this->view->set(array('msg' => 'hello'));		// equivalent to $msg = hello
		$this->view->render();  
	}
	
	
	public function formsample() {
		$this->view->load('content', $this->_name . '/formsample', array());
		if ($data = $this->input->post()) {
			echo '<pre>';
			print_r($data);
			echo '</pre>';
		}
		$this->view->render();
	}
}