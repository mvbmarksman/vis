<?php
class Sales_transaction_model extends MY_Model
{

	const TBL_NAME = 'SalesTransaction';

	public $salesTransactionId;
	public $userId;
	public $creditDetailId;
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
		$transactionId = $this->db->insert_id();
		return $transactionId;
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


	public function getDetailed($transactionId) {
		$this->db->select('st.*, s.*, id.*, c.*, cp.*, cp.amount as amountPaid');
		$this->db->from(self::TBL_NAME . ' as st');
		$this->db->join('Sales as s', 'st.salesTransactionId = s.salesTransactionId');
		$this->db->join('ItemDetail as id', 'id.itemDetailId = s.itemDetailId');
		$this->db->join('CreditDetail as c', 'c.creditDetailId = st.creditDetailId', 'left');
		$this->db->join('CreditPayment as cp',
			'cp.creditDetailId = c.creditDetailId and cp.salesTransactionId = s.salesTransactionId');
		$this->db->where('s.salesTransactionId', $transactionId);
		$query = $this->db->get();
		return $query->result_array();
	}
}