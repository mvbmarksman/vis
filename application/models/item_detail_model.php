<?php
class Item_detail_model extends MY_Model implements IAbstractDAO
{
	const TBL_NAME = 'ItemDetail';

	public $itemDetailId;
	public $productCode;
	public $itemTypeId;
	public $description;
	public $unit;
	public $buyingPrice;
	public $isUsed;
	public $sellingPrice;
	public $supplierId;

	public function save($itemDetailModel) {
		if (!$itemDetailModel instanceof Item_detail_model) {
			throw new DAOException("Parameter should be an instance of Item_detail_model class");
		}
		if (!$itemDetailModel) {
			throw new DAOException("Must specify itemDetailModel.");
		}

		if ($itemDetailModel->itemDetailId) {
			$itemDetailId = $itemDetailModel->itemDetailId;
			unset($itemDetailModel->itemDetailId);
			$this->db->update(self::TBL_NAME, $itemDetailModel, array('itemDetailId' => $itemDetailId));
			return $this->db->insert_id();
		}
		$this->db->insert(self::TBL_NAME, $itemDetailModel);
		return $this->db->insert_id();
	}


	/**
	 * Fetches item details from the database.
	 * If itemDetailId is not specified, all records are fetched
	 *
	 * @return array
	 */
	public function fetch($itemDetailId = null) {

		$this->db->select();
		$this->db->from(self::TBL_NAME);
		if ($itemDetailId) {
			$this->db->where('itemDetailId', $itemDetailId);
		}
		$query = $this->db->get();
		$result = $query->result_array();
		if ($itemDetailId) {
			return array_pop($result);
		}
		return $result;
	}


	public function delete($itemDetailId) {
		if (!$itemDetailId) {
			throw new DAOException("Must specify id to delete.");
		}
		$this->db->delete(self:: TBL_NAME, array('itemDetailId' => $itemDetailId));
	}




}

