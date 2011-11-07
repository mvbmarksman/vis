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


	public function fetchDetailed($itemId)
	{
		if (empty($itemId)) {
			throw new InvalidArgumentException('ItemId must not be empty.');
		}
		$this->db->select('i.*, it.*, s.*, sum(s.quantity) as totalQuantity')
			->from('Item i')
			->join('ItemType it', 'i.itemTypeId = it.itemTypeId')
			->join('Stock s', 's.itemId = i.itemId', 'left')
			->where('i.itemId', (int) $itemId)
			->group_by('s.itemId')
			->limit(1);
		$query = $this->db->get();
		Debug::log($this->db->last_query());
		$results = $query->row_array();
		return $results;

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