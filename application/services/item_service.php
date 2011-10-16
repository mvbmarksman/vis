<?php
class ItemService extends MY_Service
{

	const LOW_STOCK_THRESHOLD = 5;
	const RECENT_DAY_THRESHOLD = 1;

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


}