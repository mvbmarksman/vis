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


		$sales_transaction= new Sales_transaction_model();
		$sales_transaction->date = date("Y-m-d H:i:s");
		$sales_transaction->userId = 1; //TODO CHANGED
		$sales_transaction->isFullyPaid = 1;//TODO CHANGED
		$this->sales_transaction_model->save($sales_transaction);


		$qty = $this->input->post('qty');
		$itemDetailId = $this->input->post('item');
		$salesTransactionId = $this->db->insert_id();
		$discount = $this->input->post('discount');
		$storeId = 1;  //TODO change this pls
		$vat = $this->input->post('vat');

		$unitPrice=$this->item_detail_model->fetch($itemDetailId[0]);
		$ctr = 0; //initialize the array to the index
		$totalPrice = 0;

		if ($vat != null){
			foreach ($vat as $no){
				$isVAT[$no - 1]=1;
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
				$totalPrice = $totalPrice + $qty[$ctr] * $unitPrice[0]['sellingPrice'] -$discount[$ctr];

				$ctr++;
				//debug :: dump($totalPrice);
		}
		$sales_transaction ->salesTransactionId = $salesTransactionId;
		$sales_transaction ->totalPrice = $totalPrice;
		$this->sales_transaction_model->save($sales_transaction);
		//debug :: dump('success');
	}
 }