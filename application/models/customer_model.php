<?php
class Customer_model extends CI_Model
{
	const TBL_NAME = 'Customer';

	public $customerId;
	public $firstname;
	public $lastname;
	public $address;
	public $phoneNo;

	public function save($customerModel) {
		if (!$customerModel instanceof Customer_model) {
			throw new DAOException("Parameter should be an instance of Customer_model class");
		}
		if (!$customerModel) {
			throw new DAOException("Must specify customerModel.");
		}

		if ($customerModel->customerId) {
			$customerId = $customerModel->customerId;
			unset($customerModel->customerId);
			$this->db->update(self::TBL_NAME, $customerModel, array('customerId' => $customerId));
			return $this->db->insert_id();
		}
		$this->db->insert(self::TBL_NAME, $customerModel);
		return $this->db->insert_id();
	}


	/**
	 * Fetches customer details from the database.
	 * If customerId is not specified, all records are fetched
	 *
	 * @return array
	 */
	public function fetch($customerId = null) {

		$this->db->select();
		$this->db->from(self::TBL_NAME);
		if ($customerId) {
			$this->db->where('customerId', $customerId);
		}
		$query = $this->db->get();
		$result = $query->result_array();
		if ($customerId) {
			return array_pop($result);
		}
		return $result;
	}


	public function delete($customerId) {
		if (!$customerId) {
			throw new DAOException("Must specify id to delete.");
		}
		$this->db->delete(self:: TBL_NAME, array('customerId' => $customerId));
	}
}