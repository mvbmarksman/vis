<?php
class Customer_model extends MY_Model
{
	const TBL_NAME = 'Customer';

	public $customerId;
	public $fullname;
	public $address;
	public $phoneNo;


	public function insert() {
		if (empty($this->fullname)) {
			throw new InvalidArgumentException('Full name is empty.');
		}
		Debug::log('Customer_model::insert');
		Debug::log($this->__toString());
		$this->db->insert(self::TBL_NAME, $this);
		return $this->db->insert_id();
	}


	public function update()
	{
		if (empty($this->customerId)) {
			throw new InvalidArgumentException('CustomerId cannot be empty.');
		}
		Debug::log('Customer_model::update');
		Debug::log($this->__toString());
		$customerId = $this->customerId;
		unset($this->customerId);
		$this->db->update(self::TBL_NAME, $this, array('customerId' => $customerId));
		return $customerId;
	}


	public function fetchAll()
	{
		$this->db->select();
		$this->db->from(self::TBL_NAME);
		$query = $this->db->get();
		$results = $query->result_array();
		return $results;
	}


	public function __toString()
	{
		return "CustomerModel: customerId[$this->customerId], "
			. "fullname[$this->fullname], "
			. "address[$this->address], "
			. "phoneNo[$this->phoneNo] ";
	}
}