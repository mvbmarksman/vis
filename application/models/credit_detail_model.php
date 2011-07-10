<?php
class Credit_detail_model extends CI_Model
{
	const TBL_NAME = 'CreditDetail';

	public $creditDetailId;
	public $fullName;	// required
	public $address;
	public $phoneNo;

	public function save($creditDetailModel) {
		if (!$creditDetailModel instanceof Credit_detail_model) {
			throw new DAOException("Parameter should be an instance of Credit_detail_model class");
		}
		if (!$creditDetailModel) {
			throw new DAOException("Must specify creditDetailModel.");
		}

		if ($creditDetailModel->creditDetailId) {
			$creditDetailId = $creditDetailModel->creditDetailId;
			unset($creditDetailModel->creditDetailId);
			$this->db->update(self::TBL_NAME, $creditDetailModel, array('creditDetailId' => $creditDetailId));
			return $this->db->insert_id();
		}
		$this->db->insert(self::TBL_NAME, $creditDetailModel);
		return $this->db->insert_id();
	}


	/**
	 * Fetches credit details from the database.
	 * If creditDetailId is not specified, all records are fetched
	 *
	 * @return array
	 */
	public function fetch($creditDetailId = null) {

		$this->db->select();
		$this->db->from(self::TBL_NAME);
		if ($creditDetailId) {
			$this->db->where('creditDetailId', $creditDetailId);
		}
		$query = $this->db->get();
		$result = $query->result_array();
		if ($creditDetailId) {
			return array_pop($result);
		}
		return $result;
	}


	public function delete($creditDetailId) {
		if (!$creditDetailId) {
			throw new DAOException("Must specify id to delete.");
		}
		$this->db->delete(self:: TBL_NAME, array('creditDetailId' => $creditDetailId));
	}
}