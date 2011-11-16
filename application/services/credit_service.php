<?php
class CreditService extends MY_Service
{

	public $models = array(
	);


	public function fetchOverdueList()
	{
		// dueDate = date + term
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

}
