<?php
class Customer_model extends MY_Model
{
	public $customerId;
	public $fullname;
	public $address;
	public $phoneNo;

	public function __construct()
	{
		parent::__construct();
		$this->setName('Customer');
	}




	#######
	public function insert() {
		Debug::log('Customer_model::insert');
		Debug::log($this->__toString());
		if (empty($this->fullname)) {
			throw new InvalidArgumentException('Full name is empty.');
		}
		$this->db->insert($this->_name, $this);
		return $this->db->insert_id();
	}



	public function update()
	{
		Debug::log('Customer_model::update');
		Debug::log($this->__toString());
		if (empty($this->customerId)) {
			throw new InvalidArgumentException('CustomerId cannot be empty.');
		}

		$customerId = $this->customerId;
		unset($this->customerId);
		$this->db->update($this->_name, $this, array('customerId' => $customerId));
		return $customerId;
	}


	public function fetchAll()
	{
		$this->db->select();
		$this->db->from($this->_name);
		$query = $this->db->get();
		$results = $query->result_array();
		return $results;
	}


	public function fetchCustomersWithCredit()
	{
		$this->db->select('c.customerId, c.fullname')
			->from($this->_name . ' as c')
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
		$this->db->from($this->_name . ' as c');
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
		$this->db->from($this->_name . ' as c');
		if ($criteria->searchKey) {
			$this->db->where("$criteria->searchField = '$criteria->searchKey'");
		}
		return $this->db->count_all_results();
	}



	public function delete($customerIds)
	{
		if (empty($customerIds)) {
			throw new InvalidArgumentException('Must specify customerIds to delete.');
		}
		$sql = 'DELETE FROM ' . $this->_name . ' WHERE customerId IN (?)';
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