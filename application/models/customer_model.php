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


	public function fetchCustomersWithCredit()
	{
		$this->db->select('c.customerId, c.fullname')
			->from(self::TBL_NAME . ' as c')
			->join('SalesTransaction st', 'c.customerId = st.customerId')
			->where('st.isCredit = 1 and st.isFullyPaid =0')
			->group_by('st.customerId');
		$query = $this->db->get();
		$results = $query->result_array();
		return $results;
	}


	public function fetchCriteriaBased($criteria)
	{
		$this->db->select();
		$this->db->from(self::TBL_NAME . ' as c');
		if ($criteria->searchKey) {
			$this->db->where("$criteria->searchField = '$criteria->searchKey'");
		}
		$this->db->limit($criteria->recordsPerPage, $criteria->getOffset());
		$this->db->order_by($criteria->sortName, $criteria->sortOrder);
		$query = $this->db->get();
		$results = $query->result_array();
		return $results;
	}

	public function fetchCountCriteriaBased($criteria)
	{
		$this->db->select();
		$this->db->from(self::TBL_NAME . ' as c');
		if ($criteria->searchKey) {
			$this->db->where("$criteria->searchField = '$criteria->searchKey'");
		}
		return $this->db->count_all_results();
	}


	public function fetchById($customerId)
	{
		Debug::log('Customer Model::fetchById');
		if (empty($customerId)) {
			throw new InvalidArgumentException('CustomerId cannot be null.');
		}
		$sql = 'SELECT * FROM '.self::TBL_NAME.' WHERE customerId = ?';
		$query = $this->db->query($sql, array($customerId));
		Debug::log($this->db->last_query());
		$results = $query->result_array();
		return $results[0];
	}


	public function delete($customerIds)
	{
		if (empty($customerIds)) {
			throw new InvalidArgumentException('Must specify customerIds to delete.');
		}
		$sql = 'DELETE FROM '.self::TBL_NAME.' WHERE customerId IN (?)';
		$query = $this->db->query($sql, array($customerIds));
	}


	public function __toString()
	{
		return "CustomerModel: customerId[$this->customerId], "
			. "fullname[$this->fullname], "
			. "address[$this->address], "
			. "phoneNo[$this->phoneNo] ";
	}
}