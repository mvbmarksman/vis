<?php
class ItemService extends MY_Service
{

	public $models = array(
		'item',
	);


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
		$this->db->select('i.*, it.*, s.*, c.*, sum(s.quantity) as totalQuantity')
		->from('Item i')
		->join('ItemType it', 'i.itemTypeId = it.itemTypeId')
		->join('Category c', 'c.categoryId = i.categoryId', 'left')
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
		$item->itemTypeId = $data['itemTypeId'];
		$item->categoryId = $data['categoryId'];
		$item->suggestedSellingPrice = $data['price'];
		$item->active = 1;

		$query = $this->db->get_where('Item', array('productCode' => $data['productCode']));
		if ($query->num_rows() > 0) {
			throw new DuplicateRecordException('The product code ' . $data['productCode'] . ' already exists.');
		}
		return $item->insert();
	}



	public function updateSuggestedSellingPrice($itemId, $suggestedSellingPrice, $force = false)
	{
		if (empty($itemId) || empty($suggestedSellingPrice)) {
			throw new InvalidArgumentException('Required paramters are missing.');
		}
		if (!$force) {
			// do not update if the field already has a value
			$item = new Item_model();
			$item = $item->fetchByCriteria(array('itemId' => $itemId));
			$item = array_pop($item);
			if (!empty($item['suggestedSellingPrice'])) {
				Debug::log('Suggested selling price is already populated, skipping update.');
				return;
			}
		}
		$this->db->where('itemId', $itemId);
		$this->db->update('Item', array('suggestedSellingPrice' => $suggestedSellingPrice));
		Debug::log($this->db->last_query());
	}

}