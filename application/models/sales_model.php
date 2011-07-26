<?php
class Sales_model extends CI_Model
{
	const TBL_NAME = 'Sales';

	public $salesId;
  	public $salesTransactionId;
  	public $itemDetailId;
  	public $sellingPrice;
  	public $qty;
  	public $discount;
  	public $storeId;
  	public $isVAT;

	public function save($salesModel) {
		if (!$salesModel instanceof Sales_model) {
			throw new DAOException("Parameter should be an instance of Sales_model class");
		}
		if (!$salesModel) {
			throw new DAOException("Must specify salesModel.");
		}

		if ($salesModel->salesId) {
			$salesId = $salesModel->salesId;
			unset($salesModel->salesId);
			$this->db->update(self::TBL_NAME, $salesModel, array('salesId' => $salesId));
			return $this->db->insert_id();
		}
		$this->db->insert(self::TBL_NAME, $salesModel);
		return $this->db->insert_id();
	}


	/**
	 * Fetches sales details from the database.
	 * If salesId is not specified, all records are fetched
	 *
	 * @return array
	 */
	public function fetch($salesId = null) {

		$this->db->select();
		$this->db->from(self::TBL_NAME);
		if ($salesId) {
			$this->db->where('salesId', $salesId);
		}
		$query = $this->db->get();
		return $query->result_array();
	}


	public function delete($salesId) {
		if (!$salesId) {
			throw new DAOException("Must specify id to delete.");
		}
		$this->db->delete(self:: TBL_NAME, array('salesId' => $salesId));
	}
}