<?php
class Credit_payment_model extends CI_Model
{
	const TBL_NAME = 'CreditPayment';

	public $creditPaymentId;
	public $creditDetailId;	// required
	public $salesTransactionId; // required
	public $datePaid;
	public $amount;

	public function save($creditPaymentModel) {
		if (!$creditPaymentModel instanceof Credit_payment_model) {
			throw new DAOException("Parameter should be an instance of Credit_payment_model class");
		}
		if (!$creditPaymentModel) {
			throw new DAOException("Must specify creditPaymentModel.");
		}

		if ($creditPaymentModel->creditPaymentId) {
			$creditPaymentId = $creditPaymentModel->creditPaymentId;
			unset($creditPaymentModel->creditPaymentId);
			$this->db->update(self::TBL_NAME, $creditPaymentModel, array('creditPaymentId' => $creditPaymentId));
			return $this->db->insert_id();
		}
		$this->db->insert(self::TBL_NAME, $creditPaymentModel);
		return $this->db->insert_id();
	}


	/**
	 * Fetches credit details from the database.
	 * If creditPaymentId is not specified, all records are fetched
	 *
	 * @return array
	 */
	public function fetch($creditPaymentId = null) {

		$this->db->select();
		$this->db->from(self::TBL_NAME);
		if ($creditPaymentId) {
			$this->db->where('creditPaymentId', $creditPaymentId);
		}
		$query = $this->db->get();
		return $query->result_array();
	}


	public function delete($creditPaymentId) {
		if (!$creditPaymentId) {
			throw new DAOException("Must specify id to delete.");
		}
		$this->db->delete(self:: TBL_NAME, array('creditPaymentId' => $creditPaymentId));
	}
}