<?php
class Sales_transaction_model extends MY_Model
{
	const TBL_NAME = 'SalesTransaction';

	public $salesTransactionId;
	public $userId;
	public $customerId;
	public $totalPrice;
	public $totalAmountPaid;
	public $isFullyPaid;
	public $isCredit;
	public $creditTerm;


	public function insert()
	{
		if (empty($this->userId)) {
			throw new InvalidArgumentException('UserId is empty.');
		}
		Debug::log('Sales_transaction_model::insert');
		Debug::log($this->__toString());
		$this->db->insert(self::TBL_NAME, $this);
		return $this->db->insert_id();
	}


	public function update()
	{
		if (empty($this->salesTransactionId)) {
			throw new InvalidArgumentException('SalesTransactionId cannot be empty.');
		}
		Debug::log('Sales_transaction_model::update');
		Debug::log($this->__toString());
		$salesTransactionId = $this->salesTransactionId;
		unset($this->salesTransactionId);
		$this->db->update(self::TBL_NAME, $this, array('salesTransactionId' => $salesTransactionId));
		return $salesTransactionId;
	}


	public function fetch($salesTransactionId)
	{
		if (empty($salesTransactionId)) {
			throw new InvalidArgumentException('salesTransactionId cannot be empty');
		}
		$this->db->select();
		$this->db->from(self::TBL_NAME);
		$this->db->where('salesTransactionId', $salesTransactionId);
		$query = $this->db->get();
		return $query->row(0, 'Sales_transaction_model');
	}


	public function delete($salesTransactionId) {
		if (empty($salesTransactionId)) {
			throw new InvalidArgumentException('salesTransactionId cannot be empty');
		}
		$this->db->delete(self:: TBL_NAME, array('salesTransactionId' => $salesTransactionId));
	}


	public function fetchDetailed($transactionId) {
		$this->db->select('st.*, s.*, id.*, c.*');
		$this->db->from(self::TBL_NAME . ' as st');
		$this->db->join('Sales as s', 'st.salesTransactionId = s.salesTransactionId');
		$this->db->join('ItemDetail as id', 'id.itemDetailId = s.itemDetailId');
		$this->db->join('Customer as c', 'c.customerId = st.customerId', 'left');
		$this->db->where('s.salesTransactionId', $transactionId);
		$query = $this->db->get();
		return $query->result_array();
	}

//	public function gettransactiondetail($creditDetailId)
//	{
//		$this->db->select();
//		$this->db->from(self::TBL_NAME);
//		$this->db->where('creditDetailId', $creditDetailId);
//		$query = $this->db->get();
//		$result = $query->result_array();
//		return $result;
//	}


	public function __toString()
	{
		return "SalesTransactionModel: salesTransactionId[$this->salesTransactionId], "
			. "userId[$this->userId], "
			. "customerId[$this->customerId], "
			. "totalPrice[$this->totalPrice], "
			. "totalAmountPaid[$this->totalAmountPaid], "
			. "isFullyPaid[$this->isFullyPaid], "
			. "isCredit[$this->isCredit], "
			. "creditTerm[$this->creditTerm], ";
	}
}