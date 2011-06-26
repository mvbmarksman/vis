<?php
class Item_type_model extends MY_Model implements IAbstractDAO
{
	const TBL_NAME = 'ItemType';

	public $itemTypeId;
	public $name;

	public function save($itemTypeModel) {
		if (!$itemTypeModel instanceof Item_type_model) {
			throw new DAOException("Parameter should be an instance of Item_type_model class");
		}
		if (!$itemTypeModel) {
			throw new DAOException("Must specify itemTypeModel.");
		}

		if ($itemTypeModel->itemTypeId) {
			$itemTypeId = $itemTypeModel->itemTypeId;
			unset($itemTypeModel->itemTypeId);
			$this->db->update(self::TBL_NAME, $itemTypeModel, array('itemTypeId' => $itemTypeId));
			return $this->db->insert_id();
		}
		$this->db->insert(self::TBL_NAME, $itemTypeModel);
		return $this->db->insert_id();
	}


	/**
	 * Fetches item types from the database.
	 * If itemTypeId is not specified, all records are fetched
	 *
	 * @return array
	 */
	public function fetch($itemTypeId = null) {

		$this->db->select();
		$this->db->from(self::TBL_NAME);
		if ($itemTypeId) {
			$this->db->where('itemTypeId', $itemTypeId);
		}
		$query = $this->db->get();
		return $query->result_array();
	}


	public function delete($itemTypeId) {
		if (!$itemTypeId) {
			throw new DAOException("Must specify id to delete.");
		}
		$this->db->delete(self:: TBL_NAME, array('itemTypeId' => $itemTypeId));
	}




}
