<?php
class ItemTypeService extends MY_Service
{
	public $models = array(
		'item_type',
	);

	public function fetchAllItems()
	{
		$itemType = new Item_type_model();
		$results = $itemType->fetchAll();
		return $results;
	}

	public function saveOrUpdate($data)
	{
		if (empty($data)) {
			throw new InvalidArgumentException('Data cannot be empty.');
		}
		$itemType = new Item_type_model();
		$itemType->name = $data['name'];
		if (!empty($data['itemTypeId'])) {
			$itemType->itemTypeId = $data['itemTypeId'];
			$itemTypeId = $itemType->update();
			return $itemTypeId;
		}
		$itemTypeId = $itemType->insert();
		return $itemTypeId;
	}

	public function fetchCriteriaBased($criteria)
	{
		$itemType = new Item_type_model();
		$itemTypes = $itemType->fetchCriteriaBased($criteria);
		return $itemTypes;
	}

	public function fetchCountCriteriaBased($criteria)
	{
		$itemType = new Item_type_model();
		$count = $itemType->fetchCountCriteriaBased($criteria);
		return $count;
	}

	public function fetchById($itemTypeId)
	{
		$itemType = new Item_type_model();
		$itemTypeData = $itemType->fetchById($itemTypeId);
		return $itemTypeData;
	}


	public function delete($itemTypeIds)
	{
		$itemType = new Item_type_model();
		$itemType->delete($itemTypeIds);
	}

}