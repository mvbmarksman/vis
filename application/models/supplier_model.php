<?php
class Supplier_model extends MY_Model
{
	public $supplierId;
	public $name;
	public $address;


	public function __construct()
	{
		parent::__construct();
		$this->setName('Supplier');
	}


	public function fetchAll()
	{
		$this->db->select();
		$this->db->from($this->_name);
		$resultSet = $this->db->get();
		Debug::log($this->db->last_query());
		return $resultSet->result_array();
	}

	public function insert()
	{
		Debug::log($this);
		if (empty($this->name)) {
			throw new InvalidArgumentException('Supplier name cannot be null.');
		}
		$this->db->insert($this->_name, $this);
		Debug::log($this->db->last_query());
		return $this->db->insert_id();
	}


	public function update()
	{
		Debug::log();
		if (empty($this->supplierId) || empty($this->name)) {
			throw new InvalidArgumentException('SupplierId and supplier name cannot be empty.');
		}
		$supplierId = $this->supplierId;
		unset($this->supplierId);
		$this->db->update($this->_name, $this, array('supplierId' => $supplierId));
		Debug::log($this->db->last_query());
		return $supplierId;
	}

}
