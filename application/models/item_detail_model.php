<?php
class Item_detail_model extends MY_Model
{
	const TBL_NAME = 'ItemDetail';

	public $itemDetailId;
	public $productCode;
	public $itemTypeId;
	public $description;
	public $unit;
	public $buyingPrice;
	public $isUsed;
	public $supplierId;
	public $active;


	/**
	 * Fetches item details from the database.
	 * If itemDetailId is not specified, all records are fetched
	 *
	 * @return array
	 */
	public function fetchAll()
	{
		$this->db->select();
		$this->db->from(self::TBL_NAME);
		$query = $this->db->get();
		$results = $query->result_array();
		return $results;
	}

	public function insert() {
		if (empty($this->description)) {
			throw new InvalidArgumentException('Description is empty.');
		}
		$this->db->insert(self::TBL_NAME, $this);
		return $this->db->insert_id();
	}


	public function update()
	{
		Debug::log('Item_detail_model::update');
		Debug::log($this->__toString());

		if (empty($this->itemDetailId)) {
			throw new InvalidArgumentException('itemDetailId cannot be empty.');
		}
		$itemDetailId = $this->itemDetailId;
		unset($this->itemDetailId);
		$this->db->update(self::TBL_NAME, $this, array('itemDetailId' => $itemDetailId));
		return $itemDetailId;
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

	public function fetchById($itemDetailId)
	{
		Debug::log('Item_detail_model::fetchById');
		if (empty($itemDetailId)) {
			throw new InvalidArgumentException('itemDetailId cannot be null.');
		}
		$sql = 'SELECT * FROM '.self::TBL_NAME.' WHERE itemDetailId = ?';
		$query = $this->db->query($sql, array($itemDetailId));
		$results = $query->result_array();
		Debug::log($this->db->last_query());
		if (count($results) <= 0) {
			throw new EmptyResultSetException('ItemDetail record for ' . $itemDetailId . ' not found.');
		}
		return $results[0];
	}


	public function fetchDetailed($itemDetailId)
	{
		Debug::log('Item_detail_model::fetchDetailed');
		if (empty($itemDetailId)) {
			throw new InvalidArgumentException('itemDetailId cannot be null.');
		}

		$sql = 'SELECT id.*, it.*, it.name as itemTypeName, '
			 . '   s.name as supplierName, s.address as supplierAddress '
			 . 'FROM ItemDetail id '
			 . 'JOIN ItemType it ON (id.itemTypeId = it.itemTypeId) '
			 . 'LEFT JOIN Item i ON (i.itemDetailId = id.itemDetailId) '
			 . 'LEFT JOIN Supplier s ON (s.supplierId = i.supplierId) '
			 . 'WHERE id.itemDetailId = ?';

		$query = $this->db->query($sql, array($itemDetailId));
		$results = $query->result_array();
		Debug::log($this->db->last_query());
		if (count($results) <= 0) {
			throw new EmptyResultSetException('ItemDetail record for ' . $itemDetailId . ' not found.');
		}
		return $results[0];
	}



	public function delete($itemDetailIds)
	{
		if (empty($itemDetailIds)) {
			throw new InvalidArgumentException('Must specify itemDetailIds to delete.');
		}
		$sql = 'DELETE FROM '.self::TBL_NAME.' WHERE itemDetailId IN (?)';
		$query = $this->db->query($sql, array($itemDetailIds));
	}


	public function __toString()
	{
		return "ItemDetailModel: itemDetailId[$this->itemDetailId], "
			. "productCode[$this->productCode], "
			. "itemTypeId[$this->itemTypeId], "
			. "description[$this->description], "
			. "unit[$this->unit], "
			. "buyingPrice[$this->buyingPrice], "
			. "isUsed[$this->isUsed], "
			. "supplierId[$this->supplierId] "
			. "active[$this->active] ";
	}

}

