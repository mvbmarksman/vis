<?php
class Sales extends MY_Controller {


	public function __construct() {
		parent::__construct();
		$this->load->model('sales_transaction_model');
		$this->load->model('item_detail_model');
		$this->load->model('sales_model');
		$this->load->model('credit_detail_model');
		$this->load->model('credit_payment_model');
		$this->load->model('item_model');
	}

	public function salesform() {
		$itemDetails = $this->item_detail_model->fetch();
		$this->renderView('salesform', array('itemDetails' => $itemDetails));
	}

	public function processsalesform() {
		$creditDetailId = $this->_saveCreditDetail($this->input->post());

		// save Sales data
		$sales_transaction= new Sales_transaction_model();
		$sales_transaction->userId = 1; //TODO stub data
		$sales_transaction->isFullyPaid = $creditDetailId ? 0 : 1;
		$sales_transaction->creditDetailId = $creditDetailId;

		$this->sales_transaction_model->save($sales_transaction);
		$salesTransactionId = $this->db->insert_id();

		$itemDetailIds = $this->input->post('item');
		$qty = $this->input->post('qty');
		$discount = $this->input->post('discount');
		$storeId = 1;  //TODO stub data
		$vats = $this->input->post('vat');

		if (!empty($vats)) {
			foreach ($vats as $vatId){
				$isVAT[substr($vatId, 4)] = true;
			}
		}

		// save sale transactions
		$row = 1;
		$totalPrice = 0;
		unset($itemDetailIds[0]);	// remove the data coming from the template
		$salesObjs = array();
		foreach ($itemDetailIds as $itemDetailId) {
			$sales = new Sales_model();
			$sales->salesTransactionId = $salesTransactionId;
			$sales->itemDetailId = $itemDetailId;
			$itemDetailRow = $this->item_detail_model->fetch($itemDetailId);
			$sales->unitPrice = $itemDetailRow['sellingPrice'];
			$sales->discount = $discount[$row];
			$sales->storeId = $storeId;
			$sales->isVAT = (empty($isVAT[$row])) ? 0 : 1;
			$sales->qty = $qty[$row];
			$totalPrice += $qty[$row] * $itemDetailRow['sellingPrice'] - $discount[$row];
			$salesObjs[] = $sales;
			$row++;
		}

		$salesObjs = $this->_mergeSimilarItems($salesObjs);
		foreach ($salesObjs as $sales) {
			$this->sales_model->save($sales);
		}
		$sales_transaction->salesTransactionId = $salesTransactionId;
		$sales_transaction->totalPrice = $totalPrice;
		$this->sales_transaction_model->save($sales_transaction);
		$this->_saveCreditPayment($creditDetailId, $salesTransactionId, $this->input->post('creditAmount'));
		$this->load->helper('url');
		redirect('/sales/summary/?transactionId=' . $salesTransactionId, 'refresh');
	}

	private function _saveCreditDetail($data) {
		if (empty($data['creditName'])) {
			return;
		}
		$credit = new Credit_detail_model();
		$credit->fullName = $data['creditName'];
		$credit->address = $data['creditAddress'];
		$credit->phoneNo = $data['creditContact'];
		$this->credit_detail_model->save($credit);
		return $this->db->insert_id();
	}

	private function _saveCreditPayment($creditDetailId, $saleTransactionId, $amount) {
		if (empty($creditDetailId) || empty($saleTransactionId) || empty($amount)) {
			return;
		}
		$creditPayment = new Credit_payment_model();
		$creditPayment->amount = $amount;
		$creditPayment->creditDetailId = $creditDetailId;
		$creditPayment->salesTransactionId = $saleTransactionId;
		$this->credit_payment_model->save($creditPayment);
	}


	private function _mergeSimilarItems($items) {
		if (empty($items) || count($items) <= 1) {
			return $items;
		}
		$merged = array();
		foreach ($items as $item) {
			$merged[$item->itemDetailId][$item->isVAT]['salesTransactionId'] = $item->salesTransactionId;
			$merged[$item->itemDetailId][$item->isVAT]['itemDetailId'] = $item->itemDetailId;
			$merged[$item->itemDetailId][$item->isVAT]['unitPrice'] = $item->unitPrice;
			$merged[$item->itemDetailId][$item->isVAT]['storeId'] = $item->storeId;
			$merged[$item->itemDetailId][$item->isVAT]['isVAT'] = $item->isVAT;
			@$merged[$item->itemDetailId][$item->isVAT]['qty'] += $item->qty;
			@$merged[$item->itemDetailId][$item->isVAT]['discount'] += $item->discount;
		}

		$flattened = array();
		foreach ($merged as $item) {
			foreach ($item as $i) {
				$sales = new Sales_model();
				$sales->salesTransactionId = $i['salesTransactionId'];
				$sales->itemDetailId = $i['itemDetailId'];
				$sales->unitPrice = $i['unitPrice'];
				$sales->storeId = $i['storeId'];
				$sales->isVAT = $i['isVAT'];
				$sales->qty = $i['qty'];
				$sales->discount = $i['discount'];
				$flattened[] = $sales;
			}
		}
		return $flattened;
	}


	public function summary() {
		$transactionId = $this->input->get('transactionId');
		$model = 'sales_transaction_model';
		$this->load->model($model);
		$transactionDetails = $this->{$model}->getDetailed($transactionId);
		$this->renderView('summary', array('items' => $transactionDetails));
	}

}