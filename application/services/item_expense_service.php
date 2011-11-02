<?php
class ItemExpenseService extends MY_Service
{

	const DAILY = 1;
	const MONTHLY = 2;


	public $models = array(
		'item_expense',
	);


	public function saveItemExpense($data)
	{
		$itemExpense = new Item_expense_model();
		$itemExpense->itemId = $data['itemId'];
		$itemExpense->price = $data['price'];
		$itemExpense->quantity = $data['quantity'];
		$itemExpense->supplierId = !empty($data['supplierId']) ? $data['supplierId'] : null;
		$itemExpense->discount = $data['discount'];
		$itemExpense->userId = 1; // TODO hardcoded
		$itemExpense->isCredit = empty($data['credit']) ? 0 : 1;

		// leave fullyPaid to null if not a credit because we want to track expenses that were credited and then later paid
		$itemExpense->isFullyPaid = empty($data['credit']) ? null : 0;
		return $itemExpense->insert();
	}


	/**
	 *
	 * For now let's focus on a daily view,
	 * monthly view is more complicated since it will have to be paginated
	 * @param unknown_type $scope DAILY, MONTHLY, ANNUALLY
	 * @param unknown_type $range e.g. 11-01-2010 or november
	 */
	public function fetchItemExpenses($scope, $range)
	{
		$this->db->select('*')
			->from('ItemExpense ie')
			->join('Item i', 'ie.itemId = i.itemId', 'left')
			->join('Supplier s', 'ie.supplierId = s.supplierId', 'left')
			->where('DATE(ie.dateAdded) = ', date('Y-m-d', strtotime($range)))
			->order_by('ie.dateAdded', 'asc');
		$query = $this->db->get();
		$results = $query->result_array();
		Debug::log($this->db->last_query());
		return $results;
	}


}