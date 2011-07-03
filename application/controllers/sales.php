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
		$this->load->model('sales_model');
		$this->load->model('credit_model');
	}
 }