<?php
class Credit_payment_model extends MY_Model
{
	public $creditPaymentId;
	public $customerId;
	public $salesTransactionId;
	public $amount;


	public function __construct()
	{
		parent::__construct();
		$this->setName('CreditPayment');
	}


	protected function _checkArgs()
	{
		if (empty($this->customerId)) {
			throw new InvalidArgumentException('CustomerId is empty.');
		}
		if (empty($this->salesTransactionId)) {
			throw new InvalidArgumentException('SalesTransactionId is empty.');
		}
		if (empty($this->amount)) {
			throw new InvalidArgumentException('Amount is empty.');
		}
		if ($this->amount <= 0) {
			throw new InvalidArgumentException('Amount must be greater than 0.');
		}
		if (!is_numeric($this->amount)) {
			throw new InvalidArgumentException('Amount should be numeric.');
		}
	}


	public function insert()
	{
		$this->_checkArgs();
		$this->db->insert($this->_name, $this);
		return $this->db->insert_id();
	}


	public function update()
	{
		if (empty($this->creditPaymentId)) {
			throw new InvalidArgumentException('CreditPaymentId cannot be empty.');
		}
		$creditPaymentId = $this->creditPaymentId;
		unset($this->creditPaymentId);
		$this->db->update($this->_name, $this, array('creditPaymentId' => $creditPaymentId));
		return $creditPaymentId;
	}

//	public function getpaymentdetails($creditDetailId){
//		$this->db->select();
//		$this->db->from($this->_name);
//		$this->db->where('creditDetailId', $creditDetailId);
//		$query = $this->db->get();
//		$result = $query->result_array();
//		return $result;
//	}
}