<?php
class Store_model extends MY_Model
{
	const TBL_NAME = 'Store';

	public $storeId;
	public $name;
	public $location;

	public function insert() {
		if (empty($this->name)) {
			throw new InvalidArgumentException('Store Name is empty.');
		}
		Debug::log('Store_model::insert');
		Debug::log($this->__toString());
		$this->db->insert(self::TBL_NAME, $this);
		return $this->db->insert_id();
	}


	public function update()
	{
		if (empty($this->storeId)) {
			throw new InvalidArgumentException('StoreId cannot be empty.');
		}
		$storeId = $this->storeId;
		unset($this->storeId);
		$this->db->update(self::TBL_NAME, $this, array('storeId' => $storeId));
		return $storeId;
	}


	public function fetchAll()
	{
		$this->db->select();
		$this->db->from(self::TBL_NAME);
		$query = $this->db->get();
		$results = $query->result_array();
		return $results;
	}

	public function fetchCriteriaBased($criteria)
	{
		$this->db->select();
		$this->db->from(self::TBL_NAME . ' as c');
		if ($criteria->searchKey) {
			$this->db->where("$criteria->searchField = '$criteria->searchKey'");
		}
		$this->db->limit($criteria->recordsPerPage, $criteria->getOffset());
		$this->db->order_by($criteria->sortName, $criteria->sortOrder);
		$query = $this->db->get();
		$results = $query->result_array();
		return $results;
	}

	public function fetchCountCriteriaBased($criteria)
	{
		$this->db->select();
		$this->db->from(self::TBL_NAME . ' as c');
		if ($criteria->searchKey) {
			$this->db->where("$criteria->searchField = '$criteria->searchKey'");
		}
		return $this->db->count_all_results();
	}


	public function fetchById($storeId)
	{
		if (empty($storeId)) {
			throw new InvalidArgumentException('StoreId cannot be null.');
		}
		$sql = 'SELECT * FROM '.self::TBL_NAME.' WHERE storeId = ?';
		$query = $this->db->query($sql, array($storeId));
		$results = $query->result_array();
		return $results[0];
	}


	public function delete($storeIds)
	{
		if (empty($storeIds)) {
			throw new InvalidArgumentException('Must specify storeIds to delete.');
		}
		$sql = 'DELETE FROM '.self::TBL_NAME.' WHERE storeId IN (?)';
		$query = $this->db->query($sql, array($storeIds));
	}


	public function __toString()
	{
		return "StoreModel: storeId[$this->storeId], "
			. "name[$this->name], "
			. "location[$this->location] ";
	}


}