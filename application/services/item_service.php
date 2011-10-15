<?php
class ItemService extends MY_Service
{

	const LOW_STOCK_THRESHOLD = 2; 
	
	public $models = array(
		'item',
	);
	
	
	public function fetchLowInStock()
	{
		$item = new Item_model();
		return $item->fetchLowInStock(self::LOW_STOCK_THRESHOLD);
	}


}