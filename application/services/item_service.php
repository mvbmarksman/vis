<?php
class ItemService extends MY_Service
{

	const RECENT_ITEMS_LIMIT = 5;
	const RECENT_DAY_THRESHOLD = 5;

	public $models = array(
		'item',
	);


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

	public function updateLatestBuyingPrice($itemId, $latestBuyingPrice)
	{
		if (empty($itemId) || empty($latestBuyingPrice)) {
			throw new InvalidArgumentException('Required paramters are missing.');
		}
		$this->db->where('itemId', $itemId);
		$this->db->update('Item', array('latestBuyingPrice' => $latestBuyingPrice));
		Debug::log($this->db->last_query());
	}

}