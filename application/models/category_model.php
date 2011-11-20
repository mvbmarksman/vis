<?php
class Category_model extends MY_Model
{
	public $categoryId;
	public $categoryName;


	public function __construct()
	{
		parent::__construct();
		$this->setName('Category');
	}


	public function fetchAll()
	{
		$this->db->select();
		$this->db->from($this->_name);
		$query = $this->db->get();
		$results = $query->result_array();
		return $results;
	}

//	public function insert() {
//		if (empty($this->categoryName)) {
//			throw new InvalidArgumentException('Category name cannot be empty.');
//		}
//		$this->db->insert(self::TBL_NAME, $this);
//		return $this->db->insert_id();
//	}


//	public function update()
//	{
//		if (empty($this->categoryId)) {
//			throw new InvalidArgumentException('CategoryId cannot be empty.');
//		}
//		$categoryId = $this->categoryId;
//		unset($this->categoryId);
//		$this->db->update(self::TBL_NAME, $this, array('categoryId' => $categoryId));
//		return $categoryId;
//	}
//
//

//	public function fetchCriteriaBased($criteria)
//	{
//		$this->db->select();
//		$this->db->from(self::TBL_NAME . ' as c');
//		if ($criteria->searchKey) {
//			$this->db->where("$criteria->searchField = '$criteria->searchKey'");
//		}
//		$this->db->limit($criteria->recordsPerPage, $criteria->getOffset());
//		$this->db->order_by($criteria->sortName, $criteria->sortOrder);
//		$query = $this->db->get();
//		$results = $query->result_array();
//		return $results;
//	}
//
//	public function fetchCountCriteriaBased($criteria)
//	{
//		$this->db->select();
//		$this->db->from(self::TBL_NAME . ' as c');
//		if ($criteria->searchKey) {
//			$this->db->where("$criteria->searchField = '$criteria->searchKey'");
//		}
//		return $this->db->count_all_results();
//	}
//
//
//	public function fetchById($itemTypeId)
//	{
//		if (empty($itemTypeId)) {
//			throw new InvalidArgumentException('ItemTypeId cannot be null.');
//		}
//		$sql = 'SELECT * FROM '.self::TBL_NAME.' WHERE itemTypeId = ?';
//		$query = $this->db->query($sql, array($itemTypeId));
//		$results = $query->result_array();
//		return $results[0];
//	}
//
//
//	public function delete($itemTypeIds)
//	{
//		if (empty($itemTypeIds)) {
//			throw new InvalidArgumentException('Must specify itemTypeIds to delete.');
//		}
//		$sql = 'DELETE FROM '.self::TBL_NAME.' WHERE itemTypeId IN (?)';
//		$query = $this->db->query($sql, array($itemTypeIds));
//	}

}
