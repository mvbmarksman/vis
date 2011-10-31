<?php
class Supplier_model extends CI_Model
{
	public $supplierId;
	public $name;
	public $address;

	const TBL_NAME = 'Supplier';

	public function __construct()
	{
		$this->load->database();
		parent::__construct();
	}


	public function fetchAll()
	{
		$this->db->select();
		$this->db->from(self::TBL_NAME);
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
		$this->db->insert(self::TBL_NAME, $this);
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
		$this->db->update(self::TBL_NAME, $this, array('supplierId' => $supplierId));
		Debug::log($this->db->last_query());
		return $supplierId;
	}

}
