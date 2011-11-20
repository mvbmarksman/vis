<?php
class Stock_model extends MY_Model
{
	public $itemId;
	public $quantity;


	public function __construct()
	{
		parent::__construct();
		$this->setName('Stock');
	}


	public function _checkArgs()
	{
		if (!isset($this->itemId)) {
			throw new InvalidArgumentException('ItemId is missing.');
		}
		if (!isset($this->quantity)) {
			throw new InvalidArgumentException('Quantity is missing.');
		}
	}

	public function insert()
	{
		Debug::log($this);
		$this->_checkArgs();
		$this->db->insert($this->_name, $this);
		Debug::log($this->db->last_query());
		return $this->db->insert_id();
	}

	public function updateQuantity()
	{
		Debug::log($this);
		$this->_checkArgs();
		$this->db->where('itemId', $this->itemId);
		$this->db->update($this->_name, array(
			'quantity' => $this->quantity,
		));
		Debug::log($this->db->last_query());
	}

	public function fetchByCriteria($where)
	{
		if (empty($where)) {
			throw new InvalidArgumentException('Where condition is required');
		}

		$this->db->select('*')
			->from($this->_name)
			->where($where);
		$query = $this->db->get();
		$results = $query->result_array();
		Debug::log($this->db->last_query());
		return $results;
	}


}