<?php
require_once(APPPATH . 'exceptions/DAOException.php');
require_once(APPPATH . 'exceptions/DuplicateRecordException.php');
class MY_Model extends CI_Model
{
	protected $_name;

	public function __construct() {
		parent::__construct();
		$this->load->database();
	}

	/**
	 * Checks if the arguments are valid,
	 * throws an exception otherwise.
	 */
	protected function _checkArgs() {}


	public function setName($name)
	{
		$this->_name = $name;
	}


	public function insert()
	{
		$this->_checkArgs();
		$result = $this->db->insert($this->_name, $this);
		if (!$result) {
			throw new DAOException($this->db->_error_message());
		}
		Debug::log($this->db->last_query());
		return $this->db->insert_id();
	}

	public function fetchByCriteria($criteria)
	{
		if (empty($criteria) || !is_array($criteria)) {
			throw new InvalidArgumentException('Invalid criteria');
		}
		$this->db->select('*')
			->from($this->_name)
			->where($criteria);
		$query = $this->db->get();
		Debug::log($this->db->last_query());
		return $query->result_array();
	}

	public function fetchById($id)
	{
		if (empty($id)) {
			return null;
		}
		$idCol = lcfirst($this->_name) . 'Id';
		$query = $this->db->get_where($this->_name, array($idCol => (int) $id));
		Debug::log($this->db->last_query());
		return $query->row_array();
	}
}