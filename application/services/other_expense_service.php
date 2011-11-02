<?php
class OtherExpenseService extends MY_Service
{
	const DAILY = 1;
	const MONTHLY = 2;

	public $models = array(
		'other_expense',
	);


	public function saveOtherExpense($data)
	{
		$otherExpense = new Other_expense_model();
		$otherExpense->description = $data['description'];
		$otherExpense->price = $data['price'];
		$otherExpense->payee = $data['payee'];
		$otherExpense->userId = 1; // TODO hardcoded
		$otherExpense->isCredit = empty($data['credit']) ? 0 : 1;
		return $otherExpense->insert();
	}

	/**
	 * For now let's focus on a daily view,
	 * monthly view is more complicated since it will have to be paginated
	 * @param unknown_type $scope DAILY, MONTHLY, ANNUALLY
	 * @param unknown_type $range e.g. 11-01-2010 or november
	 */
	public function fetchOtherExpenses($scope, $range)
	{
		$this->db->select('*')
			->from('OtherExpense oe')
			->where('DATE(oe.dateAdded) = ', date('Y-m-d', strtotime($range)))
			->order_by('oe.dateAdded', 'asc');
		$query = $this->db->get();
		$results = $query->result_array();
		Debug::log($this->db->last_query());
		return $results;
	}

}