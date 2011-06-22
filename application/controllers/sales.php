<?php
class Sales extends MY_Controller {

	private $_name = 'sales';

	public function index() {
		$this->load->helper('form');

		$this->view->load('content', $this->_name . '/index', array());

		$this->view->set(array());		// TODO add data
		$this->view->render();
	}

	public function salesInput(){
		$this->load->model('sales_model');
		$this->view->load('content', $this->_name . '/formsample', array());
		$this->sales_model->insert();
		$this->view->render();


	}


}