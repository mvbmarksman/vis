<?php
class Sales extends MY_Controller {

	private $_name = 'sales';
	private $_name2 = 'credit';//needed to call the credit functions

	public function index() {
		$this->load->helper('form');

		$this->load->model('sales_model');
		$data['fuserId'] = array('name' => 'fuserId', 'label' => 'fuserId',);
		$data['fitemDetailId'] = array('name' => 'fitemDetailId', 'label' => 'fitemDetailId',);
		$data['funitPrice'] = array('name' => 'funitPrice', 'label' => 'funitPrice',);
		$data['fqty'] = array('name' => 'fqty', 'label' => 'fqty',);
		$data['fdiscount'] = array('name' => 'fdiscount', 'label' => 'fdiscount',);
		$data['fstoreId'] = array('name' => 'fstoreId', 'label' => 'fstoreId',);
		$data['fisVAT'] = array('name' => 'fisVAT', 'label' => 'fisVAT','value'=>'1','checked'=>'true',);
		$data['fisFullyPaid'] = array('name' => 'fisFullyPaid', 'label' => 'fisFullyPaid','value'=>'1','checked'=>'true,');

		$this->view->load('content', $this->_name . '/index', array());
		$this->view->set($data);		// TODO add data
		$this->view->render();
	}

	public function salesInput(){
		// TODO login not yet implemented
		$userId = 1;

		$isFullyPaid = $this->input->post('fisFullyPaid');


		if ($this->input->post('fisFullyPaid') == '1') {
			$this->load->model('sales_transaction_model');
			$this->view->load('content', $this->_name . '/success', array());
			$this->sales_transaction_model->insert(null);

			$this->view->render();
		}
		else
		{
			$this->view->load('content', $this->_name2 . '/index', array());
			$this->view->render();
		}
	}
	public function creditInput(){
		$this->load->model('credit_model');
		$this->credit_model->insert();
		}


	public function saveCredit() {
		$this->load->model('credit_model');
		$this->load->model('sales_transaction_model');

		$data = array(
			'fullName'		=> $this->input->post('fullName'),
            'address'		=> $this->input->post('address'),
			'phoneNo'		=> $this->input->post('phoneNo') ,
			'amountPaid'	=> $this->input->post('amountPaid'),
		);



		$lastInsertId = $this->credit_model->insert();
		$this->sales_transaction_model->insert($lastInsertId);
	}

	public function salesform() {
		$this->renderView('salesform', array());
	}


	public function salesformhandler() {
		$data = $this->input->post();
		Debug::dump($data);
	}
}