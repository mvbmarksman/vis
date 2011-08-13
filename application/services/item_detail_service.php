<?php
class ItemDetailService extends MY_Service
{
	public $models = array(
		'item_detail',
	);


	public function fetchAllItems()
	{
		$itemDetail = new Item_detail_model();
		$items = $itemDetail->fetchAll();
		return $items;
	}
}