<?php
class Sales_transaction_model extends MY_Model
{
	public $salesTransactionId;
	public $userId;
	public $customerId;
	public $totalPrice;
	public $totalVatable;
	public $totalVat;
	public $totalAmountPaid;
	public $isFullyPaid;
	public $isCredit;
	public $creditTerm;


	public function __construct()
	{
		parent::__construct();
		$this->setName('SalesTransaction');
	}


	public function insert()
	{
		if (empty($this->userId)) {
			throw new InvalidArgumentException('UserId is empty.');
		}
		Debug::log('Sales_transaction_model::insert');
		Debug::log($this->__toString());
		$this->db->insert($this->_name, $this);
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
		$this->db->update($this->_name, $this, array('salesTransactionId' => $salesTransactionId));
		return $salesTransactionId;
	}


	public function fetch($salesTransactionId)
	{
		if (empty($salesTransactionId)) {
			throw new InvalidArgumentException('salesTransactionId cannot be empty');
		}
		$this->db->select();
		$this->db->from($this->_name);
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
		$this->db->select('st.*, s.*, i.*, c.*');
		$this->db->from($this->_name . ' as st');
		$this->db->join('Sales as s', 'st.salesTransactionId = s.salesTransactionId');
		$this->db->join('Item as i', 'i.itemId = s.itemId');
		$this->db->join('Customer as c', 'c.customerId = st.customerId', 'left');
		$this->db->where('s.salesTransactionId', $transactionId);
		$query = $this->db->get();
		return $query->result_array();
	}

//	public function gettransactiondetail($creditDetailId)
//	{
//		$this->db->select();
//		$this->db->from($this->_name);
//		$this->db->where('creditDetailId', $creditDetailId);
//		$query = $this->db->get();
//		$result = $query->result_array();
//		return $result;
//	}


	public function fetchRecent($recentThreshold, $limit = null)
	{
		Debug::log('Item_model::fetchRecent');
		$query = 'SELECT * '
			   . 'FROM SalesTransaction st '
			   . 'WHERE DATE_SUB(CURDATE(), INTERVAL ? DAY) <= date '
			   . 'ORDER BY st.date DESC ';

		if (!empty($limit)) {
			$query .= 'LIMIT ' . $limit;
		}

		$resultSet = $this->db->query($query, array($recentThreshold));
		Debug::log($this->db->last_query());
		return $resultSet->result_array();
	}


	public function fetchOverdueCredits()
	{
		Debug::log('Item_model::fetchRecent');
		$query = 'SELECT DATE_ADD(`date`, INTERVAL `creditTerm` DAY) dueDate, st.* '
			   . 'FROM SalesTransaction st '
			   . 'WHERE isCredit = 1 AND '
			   . 'isFullyPaid = 0 AND '
			   . 'totalPrice > totalAmountPaid AND '
			   . 'DATE_ADD(`date`, INTERVAL `creditTerm` DAY) < CURDATE() '
			   . 'ORDER BY dueDate';

		$resultSet = $this->db->query($query, array());
		Debug::log($this->db->last_query());
		return $resultSet->result_array();
	}


	public function __toString()
	{
		return "SalesTransactionModel: salesTransactionId[$this->salesTransactionId], "
			. "userId[$this->userId], "
			. "customerId[$this->customerId], "
			. "totalPrice[$this->totalPrice], "
			. "totalVatable[$this->totalVatable], "
			. "totalVat[$this->totalVat], "
			. "totalAmountPaid[$this->totalAmountPaid], "
			. "isFullyPaid[$this->isFullyPaid], "
			. "isCredit[$this->isCredit], "
			. "creditTerm[$this->creditTerm], ";
	}
}