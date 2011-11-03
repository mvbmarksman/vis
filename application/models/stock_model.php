<?php
class Stock_model extends MY_Model
{
	const TBL_NAME = 'Stock';

	public $itemId;
	public $storeId;
	public $quantity;


	public function _checkArgs()
	{
		if (!isset($this->itemId)) {
			throw new InvalidArgumentException('ItemId is missing.');
		}
		if (!isset($this->storeId)) {
			throw new InvalidArgumentException('StoreId is missing.');
		}
		if (!isset($this->quantity)) {
			throw new InvalidArgumentException('Quantity is missing.');
		}
	}

	public function insert()
	{
		Debug::log($this);
		$this->_checkArgs();
		$this->db->insert(self::TBL_NAME, $this);
		Debug::log($this->db->last_query());
		return $this->db->insert_id();
	}

	public function updateQuantity()
	{
		Debug::log($this);
		$this->_checkArgs();
		$this->db->where('itemId', $this->itemId);
		$this->db->where('storeId', $this->storeId);
		$this->db->update(self::TBL_NAME, array(
			'quantity' => $this->quantity,
		));
		Debug::log($this->db->last_query());
	}

	public function fetchByCriteria($where)
	{
		if (empty($where)) {
			throw new InvalidArgumentException('Where condition is required');
		}

		$this->db->select()
			->from(self::TBL_NAME)
			->where($where);
		$query = $this->db->get();
		$results = $query->result_array();
		Debug::log($this->db->last_query());
		return $results;
	}


}