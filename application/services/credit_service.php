<?php
class CreditService extends MY_Service
{

	public $models = array(
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

}
