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

//		if (isset($this->input->post('name'))){
//		debug :: dump($name);


		/*$sales_transaction= new Sales_transaction_model();
		$sales_transaction->date = date("Y-m-d H:i:s");
		$sales_transaction->userId = 1; //TODO CHANGED
		$sales_transaction->isFullyPaid = 1;//TODO CHANGED
		$this->sales_transaction_model->save($sales_transaction);

		$itemDetailId = $this->input->post('item');
		$qty = $this->input->post('qty');
		$salesTransactionId = $this->db->insert_id();
		$discount = $this->input->post('discount');
		$storeId = 1;  //TODO change this pls
		$vatquery = $this->input->post('vat');

		$unitPrice=$this->item_detail_model->fetch($itemDetailId[0]);
		$ctr = 1; //initialize the array to the index
		$totalPrice = 0;

		if (($vatquery)!= null){
				foreach ($vatquery as $no){
				$isVAT[substr($no,4)] = 1;
			}
		}

		while (isset($itemDetailId[$ctr])){
			$sales= new Sales_model();
			$sales ->salesTransactionId = $salesTransactionId;
			$sales ->itemDetailId = $itemDetailId[$ctr];
			$unitPrice = $this->item_detail_model->fetch($itemDetailId[$ctr]);
			$sales ->unitPrice = $unitPrice[0]['sellingPrice'];
			$sales ->qty = $qty[$ctr];
			$sales ->discount = $discount[$ctr];
			$sales ->storeId = $storeId;
			if (isset($isVAT[$ctr])){
				$sales ->isVAT = $isVAT[$ctr];
			}
			else{
				$sales ->isVAT = 0;
			}

			$totalPrice = $totalPrice + $qty[$ctr] * $unitPrice[0]['sellingPrice'] -$discount[$ctr];
			$ctr++;
		$sales_transaction ->salesTransactionId = $salesTransactionId;
		$sales_transaction ->totalPrice = $totalPrice;
		$this->sales_transaction_model->save($sales_transaction);
		$this->sales_model->save($sales);
		debug :: dump('success');
		}
		*/

	}
 }