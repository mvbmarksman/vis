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
		$this->load->model('credit_detail_model');
		$name = $this->input->post('name');
		$creditDetailId = null;

		// TODO extract to fxn
		if (($name) != ''){
			$credit = new Credit_model();
			$credit->fullName		= $name;
			$credit->address		= $this->input->post('address');
			$credit->phoneNo	 	= $this->input->post('phoneno');
			$this->credit_model->save($credit);
			$creditDetailId = $this->db->insert_id();
		}

		$sales_transaction= new Sales_transaction_model();
		$sales_transaction->date = date("Y-m-d H:i:s");
		$sales_transaction->userId = 1; //TODO CHANGE
		$sales_transaction->isFullyPaid = $creditDetailId ? 0 : 1;
		$sales_transaction->creditDetailId = $creditDetailId;

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
			$sales->discount = $discount[$ctr];
			$sales->storeId = $storeId;
			$sales->isVAT = 0;
			$sales->itemDetailId = $itemDetailId[$ctr];
			$sales->qty = $qty[$ctr];
			if (isset($isVAT[$ctr])){
				$sales->isVAT = $isVAT[$ctr];
			}
			$totalPrice = $totalPrice + $qty[$ctr] * $unitPrice[0]['sellingPrice'] - $discount[$ctr];
			$repeat = 0;
			for ($idCtr = 1;$idCtr < $ctr && $repeat != 1;$idCtr++){
				if ($itemDetailId[$idCtr] == $itemDetailId[$ctr]){
					$sales->salesId =$salesId[$idCtr];
					$sales->itemDetailId = $itemDetailId[$ctr];
					$qtyDuplicate = $this->sales_model->fetch($salesId[$idCtr]);
					$sales->qty = $qty[$ctr] + $qtyDuplicate[0]['qty'];
					$sales->discount = $discount[$ctr] + $discount[$idCtr] ;
					$repeat = 1;
				}
			}
			$this->sales_model->save($sales);
			$salesId[$ctr] = $this->db->insert_id();
			$ctr++;
		}
		$sales_transaction->salesTransactionId = $salesTransactionId;
		$sales_transaction->totalPrice = $totalPrice;
		$this->sales_transaction_model->save($sales_transaction);

		$this->load->helper('url');
		redirect('/sales/summary/?transactionId=' . $salesTransactionId, 'refresh');
	}

	public function summary() {
		$transactionId = $this->input->get('transactionId');
		$model = 'sales_transaction_model';
		$this->load->model($model);
		$transactionDetails = $this->{$model}->getDetailed($transactionId);
		$this->renderView('summary', array('items' => $transactionDetails));
	}

}