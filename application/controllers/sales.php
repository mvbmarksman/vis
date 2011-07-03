<?php
class Sales extends MY_Controller {

	public function salesform() {
		$this->load->model('item_detail_model');
		$this->load->model('sales_model');
		$this->load->model('item_model');
		$itemDetails = $this->item_detail_model->fetch();
		$this->renderView('salesform', array('itemDetails' => $itemDetails));
	}

	public function processsalesform() {
		$this->load->model('sales_transaction_model');
		$this->load->model('item_detail_model');
		$this->load->model('sales_model');
		$this->load->model('credit_model');
		$name = $this->input->post('name');
		$creditId = null;
		
		// TODO extract to fxn
		if (($name) != ''){
			$credit = new Credit_model();
			$credit->fullName		= $name;
			$credit->address		= $this->input->post('address');
			$credit->phoneNo	 	= $this->input->post('phoneno');
			$credit->amountPaid	= $this->input->post('amountpaid');
			$this->credit_model->save($credit);
			$creditId = $this->db->insert_id();
		}
		
		$sales_transaction= new Sales_transaction_model();
		$sales_transaction->date = date("Y-m-d H:i:s");
		$sales_transaction->userId = 1; //TODO CHANGE
		$sales_transaction->isFullyPaid = $creditId ? 0 : 1;
		$sales_transaction->creditId = $creditId;
		
		$this->sales_transaction_model->save($sales_transaction);
		$itemDetailId = $this->input->post('item');
		$qty = $this->input->post('qty');
		$salesTransactionId = $this->db->insert_id();
		
		$discount = $this->input->post('discount');
		$storeId = 1;  //TODO change this pls
		
		$vat = $this->input->post('vat');
		$unitPrice = $this->item_detail_model->fetch($itemDetailId[0]);
		$totalPrice = 0;

		if (!empty($vat)) {
			foreach ($vat as $no){
				$isVAT[substr($no, 4)] = 1;
			}
		}
		
		$ctr = 1;
		while (isset($itemDetailId[$ctr])) {
			$sales = new Sales_model();
			$sales->salesTransactionId = $salesTransactionId;
			$sales->itemDetailId = $itemDetailId[$ctr];
			$unitPrice = $this->item_detail_model->fetch($itemDetailId[$ctr]);
			$sales->unitPrice = $unitPrice[0]['sellingPrice'];
			$sales->qty = $qty[$ctr];
			$sales->discount = $discount[$ctr];
			$sales->storeId = $storeId;
			$sales->isVAT = 0;
			if (isset($isVAT[$ctr])){
				$sales->isVAT = $isVAT[$ctr];
			}
			$totalPrice = $totalPrice + $qty[$ctr] * $unitPrice[0]['sellingPrice'] - $discount[$ctr];
			$ctr++;
			$this->sales_model->save($sales);
		}
		$sales_transaction->salesTransactionId = $salesTransactionId;
		$sales_transaction->totalPrice = $totalPrice;
		$this->sales_transaction_model->save($sales_transaction);
		
		$this->load->helper('url');
		redirect('/sales/summary/?transactionId=' . $salesTransactionId, 'refresh');
	}
	
	public function summary() {
		$this->load->model('sales_transaction_model');
		$salesTransactionId = $this->input->get('transactionId');
		$transactionDetails = $this->sales_transaction_model->getDetailed($salesTransactionId);
		Debug::dump($transactionDetails);
		$this->renderView('summary', array('items' => $transactionDetails));
	}
	
 }