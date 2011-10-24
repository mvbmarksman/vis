<?php
class Supplier_model extends CI_Model
{
	public $supplierId;
	public $name;
	public $discount;

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

}
