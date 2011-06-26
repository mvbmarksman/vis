<?php
class Credit_model extends CI_Model
{
	const TBL_NAME = 'Credit';

	public $creditId;
	public $fullName;	// required
	public $address;
	public $phoneNo;
	public $amountPaid;

	public function save($creditModel) {
		if (!$creditModel instanceof Credit_model) {
			throw new DAOException("Parameter should be an instance of Credit_model class");
		}
		if (!$creditModel) {
			throw new DAOException("Must specify creditModel.");
		}

		if ($creditModel->creditId) {
			$creditId = $creditModel->creditId;
			unset($creditModel->creditId);
			$this->db->update(self::TBL_NAME, $creditModel, array('creditId' => $creditId));
			return $this->db->insert_id();
		}
		$this->db->insert(self::TBL_NAME, $creditModel);
		return $this->db->insert_id();
	}


	/**
	 * Fetches credit details from the database.
	 * If creditId is not specified, all records are fetched
	 *
	 * @return array
	 */
	public function fetch($creditId = null) {

		$this->db->select();
		$this->db->from(self::TBL_NAME);
		if ($creditId) {
			$this->db->where('creditId', $creditId);
		}
		$query = $this->db->get();
		return $query->result_array();
	}


	public function delete($creditId) {
		if (!$creditId) {
			throw new DAOException("Must specify id to delete.");
		}
		$this->db->delete(self:: TBL_NAME, array('creditId' => $creditId));
	}
}