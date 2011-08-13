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

}

