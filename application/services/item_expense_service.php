<?php
class ItemExpenseService extends MY_Service
{

	const DAILY = 1;
	const MONTHLY = 2;

	const BUYING_PRICES_LIMIT = 10;

	public $models = array(
		'item_expense',
	);

	public $services = array(
		'supplier',
		'item',
		'stock',
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
		$itemExpense->isFullyPaid = empty($data['credit']) ? 1 : 0;
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


	public function fetchBuyingPricesForItem($itemId)
	{
		if (!$itemId) {
			throw new InvalidArgumentException('ItemId must be supplied.');
		}
		$this->db->select('ie.*, s.name as supplierName')
			->from('ItemExpense ie')
			->join('Supplier s', 'ie.supplierId = s.supplierId', 'left')
			->where('ie.itemId', (int) $itemId)
			->group_by(array('ie.supplierId', 'ie.price'))
			->order_by('dateAdded', 'desc')
			->limit(self::BUYING_PRICES_LIMIT);
		$query = $this->db->get();
		$results = $query->result_array();
		Debug::log($this->db->last_query());
		return $results;
	}

	public function processItemExpenseForm($data)
	{
		$this->db->trans_begin();
		try {
			$itemService = new ItemService();
			if ($data['newItem'] == 1) {
				$data['itemId'] = $itemService->saveItem($data);
			}

			if ($data['supplier']) {
				$supplierService = new SupplierService();
				$data['supplierId'] = $supplierService->saveOrUpdate($data);
			}

			$stockService = new StockService();
			$stockService->addItemsToStock($data['itemId'], $data['quantity']);
			$itemExpenseService = new ItemExpenseService();
			$itemExpenseService->saveItemExpense($data);
			$itemService->updateSuggestedSellingPrice($data['itemId'], $data['price']);

		} catch (Exception $e) {
			$this->db->trans_rollback();
			throw new Exception($e->getMessage());
		}
		$this->db->trans_commit();
	}


	public function getTotalExpense($date)
	{
		$this->db->select('SUM(price * quantity - discount) as total')
			->from('ItemExpense')
			->where('DATE(dateAdded)', $date);
		$query = $this->db->get();
		Debug::log($this->db->last_query());
		$result = $query->row_array();
		return $result['total'];
	}

}