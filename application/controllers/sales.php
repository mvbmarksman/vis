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
		Debug::dump($this->input->post());
		$customerId = $this->_saveCustomer($this->input->post());
die();
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


	/**
	 * Saves/updates customer info
	 * @param unknown_type $data
	 */
	private function _saveCustomer($data) {
		$customer = new Customer_model();
		$customer->customerId = $data['customerId'];
		$customer->fullname = $data['name'];
		$customer->address = $data['address'];
		$customer->phoneNo = $data['contact'];
		$this->customer_model->save($customer);
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