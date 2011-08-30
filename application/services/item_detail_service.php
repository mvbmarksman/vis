<?php
class ItemDetailService extends MY_Service
{
	public $models = array(
		'itemDetail',
	);


	public function fetchAllItems()
	{
		$itemDetail = new Item_detail_model();
		$items = $itemDetail->fetchAll();
		return $items;
	}

	public function saveOrUpdate($data)
	{
		if (empty($data)) {
			throw new InvalidArgumentException('Data cannot be empty.');
		}
		$itemDetail = new Item_detail_model();
		$itemDetail->productCode = $data['productCode'];
		$itemDetail->itemTypeId = $data['itemTypeId'];
		$itemDetail->description = $data['description'];
		$itemDetail->unit = $data['unit'];
		$itemDetail->buyingPrice = $data['buyingPrice'];
		$itemDetail->isUsed = $data['isUsed'];
		$itemDetail->supplierId = $data['supplierId'];

		if (!empty($data['itemDetailId'])) {
			$itemDetail->itemDetailId = $data['itemDetailId'];
			$itemDetailId = $itemDetail->update();
			return $itemDetailId;
		}
		$itemDetailId = $itemDetail->insert();
		return $itemDetailId;
	}

	public function fetchCriteriaBased($criteria)
	{
		$itemDetail = new Item_detail_model();
		$itemDetails = $itemDetail->fetchCriteriaBased($criteria);
		return $itemDetails;
	}

	public function fetchCountCriteriaBased($criteria)
	{
		$itemDetail = new Item_detail_model();
		$count = $itemDetail->fetchCountCriteriaBased($criteria);
		return $count;
	}

	public function fetchById($itemDetailId)
	{
		$itemDetail = new Item_detail_model();
		$itemDetailData = $itemDetail->fetchById($itemDetailId);
		return $itemDetailData;
	}


	public function delete($itemDetailIds)
	{
		$itemDetail = new Item_detail_model();
		$itemDetail->delete($itemDetailIds);
	}
}