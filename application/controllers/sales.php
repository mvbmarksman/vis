<?php
class Sales extends MY_Controller {



	public function createsalesform() {

		$this->load->model('item_detail_model');
		$this->load->model('sales_model');
		$this->load->model('item_model');
		$itemDetails = $this->item_detail_model->fetch();
		$this->renderView('createsalesform', array('itemDetails' => $itemDetails));
	}


	public function managesalesform() {
		$this->load->model('sales_transaction_model');
		$this->load->model('item_detail_model');

		/*$sales_transaction= new Sales_transaction_model();
		$sales_transaction->date = date("Y-m-d H:i:s");
		$sales_transaction->userId = 1; //TODO CHANGED
		$sales_transaction->isFullyPaid = 1;//TODO CHANGED
		$this->sales_transaction_model->save($sales_transaction);

		$data = $this->db->insert_id();
*/
		$storeId = 1; //TODO change this pls
		$salesTransactionId = $this->db->insert_id();
		$itemDetailId = $this->input->post('item');
		$unitPrice =
		$discount = $this->input->post('discount');
		$vat = $this->input->post('vat');
		$qty = $this->input->post('qty');
		debug :: dump($data);
	}

 /*public function index() {
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
	*/
}