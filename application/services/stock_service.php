<?php
class StockService extends MY_Service
{
	public $models = array(
		'stock',
	);


	/**
	 * This function checks first if there's already an existing record
	 * for the item in the store.
	 * If there is none, it create a new record,
	 * otherwise, it merely updates the quantity for that record.
	 */
	public function addItemToStore($itemId, $storeId, $quantity)
	{
		$this->db->select('itemId, quantity')
			->from('Stock')
			->where('itemId', $itemId)
			->where('storeId', $storeId)
			->limit(1);
		$query = $this->db->get();
		$result = $query->row_array();
		Debug::log($result);

		$stock = new Stock_model();
		$stock->itemId = $itemId;
		$stock->storeId = $storeId;
		$stock->quantity = $quantity;

		if ($query->num_rows() > 0) {
			$stock->quantity = (int) $result['quantity'] + $quantity;
			$stock->updateQuantity();
		} else {
			$stock->insert();
		}
	}


}