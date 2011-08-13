<?php
class Credit_payment_model extends CI_Model
{
	const TBL_NAME = 'CreditPayment';

	public $creditPaymentId;
	public $customerId;
	public $salesTransactionId;
	public $datePaid;
	public $amount;


	public function insert()
	{
		if (empty($this->customerId)) {
			throw new InvalidArgumentException('CustomerId is empty.');
		}
		if (empty($this->salesTransactionId)) {
			throw new InvalidArgumentException('SalesTransactionId is empty.');
		}
		$this->db->insert(self::TBL_NAME, $this);
		return $this->db->insert_id();
	}


	public function update()
	{
		if (empty($this->creditPaymentId)) {
			throw new InvalidArgumentException('CreditPaymentId cannot be empty.');
		}
		$creditPaymentId = $this->creditPaymentId;
		unset($this->creditPaymentId);
		$this->db->update(self::TBL_NAME, $this, array('creditPaymentId' => $creditPaymentId));
		return $creditPaymentId;
	}

//	public function getpaymentdetails($creditDetailId){
//		$this->db->select();
//		$this->db->from(self::TBL_NAME);
//		$this->db->where('creditDetailId', $creditDetailId);
//		$query = $this->db->get();
//		$result = $query->result_array();
//		return $result;
//	}
}