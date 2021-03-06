<?php
require_once(APPPATH . 'exceptions/RecordNotFoundException.php');
class StockService extends MY_Service
{
	const LOW_STOCK_QUANTITY_THRESHOLD = 5;
	const LOW_STOCK_DISPLAY_LIMIT = 5;

	public $models = array(
		'stock',
	);


	/**
	 * This function checks first if there's already an existing record for the item.
	 * If there is none, it create a new record,
	 * otherwise, it merely updates the quantity for that record.
	 */
	public function addItemsToStock($itemId, $quantity)
	{
		$stock = new Stock_model();
		$results = $stock->fetchByCriteria(array(
			'itemId'	=> $itemId,
		));

		$stock->itemId = $itemId;
		$stock->quantity = $quantity;
		if (count($results) > 0) {
			$stock->quantity = (int) $results[0]['quantity'] + $quantity;
			$stock->updateQuantity();
		} else {
			$stock->insert();
		}
	}


	/**
	 * This function checks first if the item exists and that there are enough items.
	 */
	public function removeItemsFromStock($itemId, $quantity)
	{
		$stock = new Stock_model();
		$results = $stock->fetchByCriteria(array(
			'itemId'	=> $itemId,
		));
		Debug::log('Trying to remove items from the stock');
		Debug::log($results);
		if (count($results) == 0) {
			throw new RecordNotFoundException('Unable to remove item from the stock because it does not exist.');
		}
		if ($results[0]['quantity'] < $quantity) {
			throw new Exception("Not enough items are available ({$results[0]['quantity']}).");
		}
		$stock->itemId = $itemId;
		$stock->quantity = (int) $results[0]['quantity'] - $quantity;
		$stock->updateQuantity();
	}


	function fetchLowInStock()
	{
		$this->db->select('s.*, sum(quantity) as totalQuantity, i.*')
			->from('Stock s')
			->join('Item i', 's.itemId = i.itemId')
			->group_by('s.itemId')
			->having('totalQuantity < ' . self::LOW_STOCK_QUANTITY_THRESHOLD);
		$query = $this->db->get();
		$results = $query->result_array();
		Debug::log($this->db->last_query());
		Debug::log($results);
		return $results;
	}


}