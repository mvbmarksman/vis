<?php
class StoreService extends MY_Service
{
	public $models = array(
		'store',
	);

	public function fetchAllItems()
	{
		$store = new Store_model();
		$results = $store->fetchAll();
		return $results;
	}

	public function saveOrUpdate($data)
	{
		if (empty($data)) {
			throw new InvalidArgumentException('Data cannot be empty.');
		}
		$store = new Store_model();
		$store->name = $data['name'];
		$store->location = $data['location'];
		if (!empty($data['storeId'])) {
			$store->storeId = $data['storeId'];
			$storeId = $store->update();
			return $storeId;
		}
		$storeId = $store->insert();
		return $storeId;
	}

	public function fetchCriteriaBased($criteria)
	{
		$store = new Store_model();
		$stores = $store->fetchCriteriaBased($criteria);
		return $stores;
	}

	public function fetchCountCriteriaBased($criteria)
	{
		$store = new Store_model();
		$count = $store->fetchCountCriteriaBased($criteria);
		return $count;
	}

	public function fetchById($storeId)
	{
		$store = new Store_model();
		$storeData = $store->fetchById($storeId);
		return $storeData;
	}


	public function delete($storeIds)
	{
		$store = new Store_model();
		$store->delete($storeIds);
	}

}