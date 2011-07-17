<?php
class Store_model extends CI_Model
{
	const TBL_NAME = 'Store';

	public $storeId;
	public $name;
	public $location;

	public function fetch($storeId = null) {

		$this->db->select();
		$this->db->from(self::TBL_NAME);
		if ($storeId) {
			$this->db->where('storeId', $storeId);
		}
		$query = $this->db->get();
		$result = $query->result_array();

		if ($storeId) {
			return array_pop($result);
		}
		return $result;
	}
}