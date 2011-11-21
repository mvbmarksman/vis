<?php
class CreditService extends MY_Service
{

	public $models = array(
		'credit_payment',
		'sales_transaction',
	);


	public function fetchOverdueList()
	{
		// overdue if currentDate > dueDate
		$this->db->select('st.*, c.*')
			->from('SalesTransaction st')
			->join('Customer c', 'c.customerId=st.customerId', 'left')
			->where('CURDATE() > st.dueDate')
			->where('isCredit = 1')
			->where('isFullyPaid = 0');
		$query = $this->db->get();
		Debug::log($this->db->last_query());
		return $query->result_array();
	}


	public function fetchCreditsAndPaymentsForCustomer($customerId)
	{
		if (empty($customerId)) {
			return array();
		}

		$this->db->select('*')
			->from('SalesTransaction st')
			->where('st.isCredit = 1')
			->where('st.customerId', (int) $customerId)
			->order_by('isFullyPaid DESC, transactionDate');
		$query = $this->db->get();
		Debug::log($this->db->last_query());
		$results = $query->result_array();

		foreach ($results as $key => $result) {
			$results[$key]['creditPayments'] = $this->_fetchCreditPayments($result['salesTransactionId'], $customerId);
		}
		return $results;
	}


	public function _fetchCreditPayments($salesTransactionId, $customerId)
	{
		if (empty($salesTransactionId) || empty($customerId)) {
			return array();
		}
		$this->db->select('*')
			->from('CreditPayment cp')
			->where('salesTransactionId', (int) $salesTransactionId)
			->where('customerId', (int) $customerId)
			->order_by('datePaid');

		$query = $this->db->get();
		return $query->result_array();
	}


	public function addCreditPayment($data)
	{
		$this->db->trans_begin();
		try {
			$salesTransactionModel = new Sales_transaction_model();
			$salesTransaction = $salesTransactionModel->fetchById($data['salesTransactionId']);
			$updatedPaidAmount = (float) $data['amount'] + (float) $salesTransaction['totalAmountPaid'];

			if ($updatedPaidAmount > $salesTransaction['totalPrice']) {
				throw new Exception('Amount paid will exceed total transaction amount.');
			}

			$creditPaymentModel = new Credit_payment_model();
			$creditPaymentModel->customerId = $data['customerId'];
			$creditPaymentModel->salesTransactionId = $data['salesTransactionId'];
			$creditPaymentModel->amount = $data['amount'];
			$creditPaymentModel->insert();

			$updateData = array(
				'totalAmountPaid' => $updatedPaidAmount,
			);
			if ($updatedPaidAmount == $salesTransaction['totalPrice']) {
				$updateData['isFullyPaid'] = 1;
			}
			$this->db->where('salesTransactionId', $data['salesTransactionId']);
			$this->db->update('SalesTransaction', $updateData);

		} catch (Exception $e) {
			$this->db->trans_rollback();
			throw new Exception($e->getMessage());
		}
		$this->db->trans_commit();
	}

}
