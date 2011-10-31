<?php
class ItemService extends MY_Service
{

	const LOW_STOCK_THRESHOLD = 5;
	const LOW_STOCK_LIMIT = 5;
	const RECENT_ITEMS_LIMIT = 5;
	const RECENT_DAY_THRESHOLD = 5;

	public $models = array(
		'item',
	);


	public function fetchLowInStock()
	{
		$item = new Item_model();
		return $item->fetchLowInStock(self::LOW_STOCK_THRESHOLD);
	}


	public function fetchRecentlyAdded()
	{
		$item = new Item_model();
		return $item->fetchRecentlyAdded(self::RECENT_DAY_THRESHOLD);
	}


	public function fetchItemsForAutocomplete()
	{
		$query = $this->db->get('Item');
		$items = $query->result_array();
		foreach ($items as $key => $item) {
			$items[$key]['label'] = $item['description'];
			$items[$key]['value'] = $item['description'];
		}
		return $items;
	}

	public function saveItem($data)
	{
		$item = new Item_model();
		$item->productCode = $data['productCode'];
		$item->description = $data['itemName'];
		$item->itemTypeId = $data['itemType'];
		$item->isUsed = !empty($data['isUsed']) ? 1 : 0;
		$item->latestBuyingPrice = $data['price'];
		$item->active = 1;
		return $item->insert();
	}


}