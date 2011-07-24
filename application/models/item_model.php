<?php
class Item_model extends CI_Model
{
	const TBL_NAME = 'Item';

	public $itemId;
	public $itemDetailId;
	public $storeId;

	public function save($itemModel) {
		if (!$itemModel instanceof Item_model) {
			throw new DAOException("Parameter should be an instance of Item_model class");
		}
		if (!$itemModel) {
			throw new DAOException("Must specify itemModel.");
		}

		if ($itemModel->itemId) {
			$itemId = $itemModel->itemId;
			unset($itemModel->itemId);
			$this->db->update(self::TBL_NAME, $itemModel, array('itemId' => $itemId));
			return $this->db->insert_id();
		}
		$this->db->insert(self::TBL_NAME, $itemModel);
		return $this->db->insert_id();
	}


	/**
	 * Fetches item details from the database.
	 * If itemId is not specified, all records are fetched
	 *
	 * @return array
	 */
	public function fetch($itemId = null) {

		$this->db->select();
		$this->db->from(self::TBL_NAME);
		if ($itemId) {
			$this->db->where('itemId', $itemId);
		}
		$query = $this->db->get();
		$result = $query->result_array();

		if ($itemId) {
			return array_pop($result);
		}
		return $result;
	}


	public function delete($itemId) {
		if (!$itemId) {
			throw new DAOException("Must specify id to delete.");
		}
		$this->db->delete(self:: TBL_NAME, array('itemId' => $itemId));
	}

	public function updateitems($itemdata){
		$query ='update '. self::TBL_NAME .' set `storeId` = ' . $itemdata['toStore'] .
				' where `storeId` != ' . $itemdata['toStore'].
				' and `itemDetailId` = ' . $itemdata['item'].
				' limit  '. $itemdata['qty'];
		$this->db->query($query);
	}
}