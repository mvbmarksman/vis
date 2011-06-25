<?php
class Sales_transaction_model extends CI_Model
{

	const TBL_NAME = 'SalesTransaction';

	public $salesTransactionId;
	public $date;
	public $userId;
	public $creditId;
	public $totalPrice;
	public $isFullyPaid;

	public function save($salesTransactionModel) {
		if (!$salesTransactionModel instanceof Sales_transaction_model) {
			throw new DAOException("Parameter should be an instance of Sales_transaction_model class");
		}
		if (!$salesTransactionModel) {
			throw new DAOException("Must specify salesTransactionModel.");
		}

		if ($salesTransactionModel->salesTransactionId) {
			$salesTransactionId = $salesTransactionModel->salesTransactionId;
			unset($salesTransactionModel->salesTransactionId);
			$this->db->update(self::TBL_NAME, $salesTransactionModel, array('salesTransactionId' => $salesTransactionId));
			return $this->db->insert_id();
		}
		$this->db->insert(self::TBL_NAME, $salesTransactionModel);
		return $this->db->insert_id();
	}


	/**
	 * Fetches sales details from the database.
	 * If salesTransactionId is not specified, all records are fetched
	 *
	 * @return array
	 */
	public function fetch($salesTransactionId = null) {

		$this->db->select();
		$this->db->from(self::TBL_NAME);
		if ($salesTransactionId) {
			$this->db->where('salesTransactionId', $salesTransactionId);
		}
		$query = $this->db->get();
		return $query->result_array();
	}


	public function delete($salesTransactionId) {
		if (!$salesTransactionId) {
			throw new DAOException("Must specify id to delete.");
		}
		$this->db->delete(self:: TBL_NAME, array('salesTransactionId' => $salesTransactionId));
	}
}