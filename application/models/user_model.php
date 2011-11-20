<?php
class User_model extends MY_Model
{
	public $userId;
	public $username;
	public $password;
	public $lastName;
	public $firstName;
	public $isAdmin;

	public function __construct()
	{
		parent::__construct();
		$this->setName('User');
	}

	public function insert() {
		if (empty($this->username)) {
			throw new InvalidArgumentException('Username is empty.');
		}
		Debug::log('User_model::insert');
		Debug::log($this->__toString());
		$this->db->insert($this->_name, $this);
		return $this->db->insert_id();
	}


	public function update()
	{
		if (empty($this->userId)) {
			throw new InvalidArgumentException('UserId cannot be empty.');
		}
		Debug::log('User_model::update');
		Debug::log($this->__toString());
		$userId = $this->userId;
		unset($this->userId);
		$this->db->update($this->_name, $this, array('userId' => $userId));
		return $userId;
	}


	public function fetchAll()
	{
		$this->db->select();
		$this->db->from($this->_name);
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


	public function fetchById($userId)
	{
		if (empty($userId)) {
			throw new InvalidArgumentException('UserId cannot be null.');
		}
		$sql = 'SELECT * FROM '.$this->_name.' WHERE userId = ?';
		$query = $this->db->query($sql, array($userId));
		$results = $query->result_array();
		return $results[0];
	}


	public function delete($userIds)
	{
		if (empty($userIds)) {
			throw new InvalidArgumentException('Must specify userIds to delete.');
		}
		$sql = 'DELETE FROM '.$this->_name.' WHERE userId IN (?)';
		$query = $this->db->query($sql, array($userIds));
	}


	public function __toString()
	{
		return "UserModel: userId[$this->userId], "
			. "username[$this->username], "
			. "password[$this->password], "
			. "firstName[$this->firstName], "
			. "lastName[$this->lastName], "
			. "isAdmin[$this->isAdmin] ";
	}

}