<?php
class SalesTransactionService extends MY_Service
{
	public $models = array(
		'sales_transaction',
		'credit_payment',
	);


	public function insert($data)
	{
		if (empty($data)) {
			throw new InvalidArgumentException('Data cannot be null.');
		}
		$salesTransaction = new Sales_transaction_model();
		$salesTransaction->userId = 1; //TODO stub data
		$salesTransaction->customerId = $data['customerId'];
		$salesTransactionId = $salesTransaction->insert();
		return $salesTransactionId;
	}


	public function update($data)
	{
		if (empty($data)) {
			throw new InvalidArgumentException('Data cannot be null.');
		}
		$salesTransaction = new Sales_transaction_model();
		$salesTransaction = $salesTransaction->fetch($data['salesTransactionId']);
		$salesTransaction->totalPrice = $data['totalPrice'];
		$salesTransaction->totalAmountPaid = $data['amountPaid'];
		if ($data['totalPrice'] == $data['amountPaid']) {
			$salesTransaction->isFullyPaid = 1;
			$salesTransaction->isCredit = 0;
		} else {
			$salesTransaction->isFullyPaid = 0;
			$salesTransaction->isCredit = 1;
			$salesTransaction->creditTerm = $data['term'];
			$this->_saveCreditPayment($data);
		}
		$salesTransaction->update();
	}


	private function _insertCreditPayment($data)
	{
		if (empty($data)) {
			throw new InvalidArgumentException('Data cannot be null.');
		}
		$creditPayment = new Credit_payment_model();
		$creditPayment->customerId = $data['customerId'];
		$creditPayment->salesTransactionId = $data['salesTransactionId'];
		$creditPayment->amount = $data['amountPaid'];
		$creditPayment->insert();
	}


	public function fetchDetailed($salesTransactionId)
	{
		if (empty($salesTransactionId)) {
			throw new InvalidArgumentException('salesTransactionId cannot be empty.');
		}
		$salesTransaction = new Sales_transaction_model();
		return $salesTransaction->fetchDetailed($salesTransactionId);
	}
}