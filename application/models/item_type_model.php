<?php
class Item_type_model extends MY_Model
{
	public $itemTypeId;
	public $name;


	public function __construct()
	{
		parent::__construct();
		$this->setName('ItemType');
	}

	public function insert() {
		if (empty($this->name)) {
			throw new InvalidArgumentException('Item Type Name is empty.');
		}
		$this->db->insert($this->_name, $this);
		return $this->db->insert_id();
	}


	public function update()
	{
		if (empty($this->itemTypeId)) {
			throw new InvalidArgumentException('ItemTypeId cannot be empty.');
		}
		$itemTypeId = $this->itemTypeId;
		unset($this->itemTypeId);
		$this->db->update($this->_name, $this, array('itemTypeId' => $itemTypeId));
		return $itemTypeId;
	}


	public function fetchAll()
	{
		$this->db->select();
		$this->db->from($this->_name);
		$query = $this->db->get();
		$results = $query->result_array();
		return $results;
	}

	public function fetchCriteriaBased($criteria)
	{
		$this->db->select();
		$this->db->from($this->_name . ' as c');
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
		$this->db->from($this->_name . ' as c');
		if ($criteria->searchKey) {
			$this->db->where("$criteria->searchField = '$criteria->searchKey'");
		}
		return $this->db->count_all_results();
	}


	public function fetchById($itemTypeId)
	{
		if (empty($itemTypeId)) {
			throw new InvalidArgumentException('ItemTypeId cannot be null.');
		}
		$sql = 'SELECT * FROM '.$this->_name.' WHERE itemTypeId = ?';
		$query = $this->db->query($sql, array($itemTypeId));
		$results = $query->result_array();
		return $results[0];
	}


	public function delete($itemTypeIds)
	{
		if (empty($itemTypeIds)) {
			throw new InvalidArgumentException('Must specify itemTypeIds to delete.');
		}
		$sql = 'DELETE FROM '.$this->_name.' WHERE itemTypeId IN (?)';
		$query = $this->db->query($sql, array($itemTypeIds));
	}


	public function __toString()
	{
		return "ItemTypeModel: itemTypeId[$this->itemTypeId], "
			. "name[$this->name] ";
	}
}
