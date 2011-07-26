<?php
class Sales extends MY_Controller
{
	public $models = array(
		'sales_model',
		'sales_transaction_model',
		'item_model',
		'item_detail_model',
		'customer_model',
		'credit_payment_model',
	);

	public $libs = array(
		'view',
	);

	public function salesform() {
		$this->view->addCss('salesform.css');
		$this->view->addJs('validator.js');
		$this->view->addJs('salesform.js');
		$itemDetails = $this->item_detail_model->fetch();
		$creditDetailsForm = $this->view->load('creditdetailsform', 'sales/_creditdetailsform', array());
		$this->renderView('salesform', array(
			'itemDetails' => $itemDetails,
			'creditDetailsForm' => $creditDetailsForm)
		);
	}

	public function getautocompletedata() {
		$items = $this->item_detail_model->fetch();
		foreach ($items as $key => $item) {
			$items[$key]['label'] = $item['description'];
			$items[$key]['value'] = $item['description'];
		}
		echo json_encode($items);
	}


	public function processsalesform() {
//		Debug::dump($this->input->post());
//		die();
		$customerId = $this->_saveCustomer($this->input->post());
		// save sales transaction data
		$sales_transaction= new Sales_transaction_model();
		$sales_transaction->userId = 1; //TODO stub data
		$sales_transaction->customerId = $customerId;
		$this->sales_transaction_model->save($sales_transaction);
		$salesTransactionId = $this->db->insert_id();

		$itemDetailIds = $this->input->post('item');
		$qty = $this->input->post('qty');
		$discount = $this->input->post('discount');
		$price = $this->input->post('price');
		$storeId = 1;  //TODO stub data
		$vats = $this->input->post('vat');

		if (!empty($vats)) {
			foreach ($vats as $vatId){
				$isVAT[substr($vatId, 4)] = true;
			}
		}

		$totalPrice = 0;
		$salesObjs = array();
		// we start from 1 to remove data coming from template
		for ($i = 1; $i < count($itemDetailIds); $i++) {
			$sales = new Sales_model();
			$sales->salesTransactionId = $salesTransactionId;
			$sales->itemDetailId = $itemDetailIds[$i];
			$itemDetailRow = $this->item_detail_model->fetch($itemDetailIds[$i]);
			$sales->sellingPrice = $price[$i];
			$sales->discount = $discount[$i];
			$sales->storeId = $storeId;
			$sales->isVAT = (empty($isVAT[$i])) ? 0 : 1;
			$sales->qty = $qty[$i];
			$totalPrice += $qty[$i] * $price[$i] - $discount[$i];
			$salesObjs[] = $sales;
		}

		$salesObjs = $this->_mergeSimilarItems($salesObjs);
		foreach ($salesObjs as $sales) {
			$this->sales_model->save($sales);
		}
		$sales_transaction->salesTransactionId = $salesTransactionId;
		$sales_transaction->totalPrice = $totalPrice;
		if ($totalPrice == $this->input->post('amountPaid')) {
			$sales_transaction->isFullyPaid = 1;
			$sales_transaction->isCredit = 0;
		} else {
			$sales_transaction->isFullyPaid = 0;
			$sales_transaction->isCredit = 1;
			$sales_transaction->creditTerm = $this->input->post('term');
			$this->_saveCreditPayment($customerId, $salesTransactionId, $this->input->post('amountPaid'));
		}
		$this->sales_transaction_model->save($sales_transaction);
		$this->load->helper('url');
		redirect('/sales/summary/?transactionId=' . $salesTransactionId, 'refresh');
	}


	/**
	 * If customerId is present, the customer information simply gets updated
	 * Otherwise, we create a new customer based on the details provided in the form
	 *
	 * @param $data - post data
	 */
	private function _saveCustomer($data) {
		$customer = new Customer_model();
		$customer->customerId = $data['customerId'];
		$customer->fullname = $data['name'];
		$customer->address = $data['address'];
		$customer->phoneNo = $data['contact'];
		$this->customer_model->save($customer);
		return empty($data['customerId']) ? $this->db->insert_id() : $data['customerId'];
	}

	private function _saveCreditPayment($customerId, $saleTransactionId, $amount) {
		if (empty($customerId) || empty($saleTransactionId) || empty($amount)) {
			throw new IllegalArgumentsException("Supplied invalid arguments. customerId: $customerId saleTransactionId: $saleTransactionId amount: $amount");
		}
		$creditPayment = new Credit_payment_model();
		$creditPayment->customerId = $customerId;
		$creditPayment->salesTransactionId = $saleTransactionId;
		$creditPayment->amount = $amount;
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
			$merged[$item->itemDetailId][$item->isVAT]['sellingPrice'] = $item->unitPrice;
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
				$sales->sellingPrice = $i['sellingPrice'];
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