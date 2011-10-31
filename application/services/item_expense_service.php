<?php
class ItemExpenseService extends MY_Service
{

	public $models = array(
		'item_expense',
	);


//	public function fetchLowInStock()
//	{
//		$item = new Item_model();
//		return $item->fetchLowInStock(self::LOW_STOCK_THRESHOLD);
//	}
//
//
//	public function fetchRecentlyAdded()
//	{
//		$item = new Item_model();
//		return $item->fetchRecentlyAdded(self::RECENT_DAY_THRESHOLD);
//	}
//
//
//	public function fetchItemsForAutocomplete()
//	{
//		$query = $this->db->get('Item');
//		$items = $query->result_array();
//		foreach ($items as $key => $item) {
//			$items[$key]['label'] = $item['description'];
//			$items[$key]['value'] = $item['description'];
//		}
//		return $items;
//	}

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
		$itemExpense->isFullyPaid = empty($data['isFullyPaid']) ? 0 : 1;
		return $itemExpense->insert();
	}


}