<?php
require_once APPPATH . 'exceptions/DuplicateRecordException.php';
class Item_model extends MY_Model
{
	const TBL_NAME = 'Item';

	public $itemId;
	public $productCode;
	public $description;
	public $itemTypeId;
	public $isUsed;
	public $latestBuyingPrice;
	public $dateAdded;
	public $active;


//	public function fetchLowInStock($lowStockThreshold, $limit = null)
//	{
//		Debug::log('Item_model::fetchLowInStock');
//		if (empty($lowStockThreshold)) {
//			$lowStockThreshold = 0;
//		}
//
//		$query = 'SELECT id.itemDetailId, id.productCode, id.description, id.active, COUNT(i.itemDetailid) AS count '
//			   . 'FROM ItemDetail id '
//			   . 'LEFT JOIN Item i ON (id.itemDetailId = i.itemDetailId) '
//			   . 'GROUP BY i.itemDetailId '
//			   . 'HAVING id.active = 1 AND count <= ? '
//			   . 'ORDER BY count ';
//
//		if (!empty($limit)) {
//			$query .= 'LIMIT ' . $limit;
//		}
//
//		$resultSet = $this->db->query($query, array($lowStockThreshold));
//		Debug::log($this->db->last_query());
//		return $resultSet->result_array();
//	}
//
//
//
//	/**
//	 * Fetches items that have been recently added (through purchase)
//	 * If there are multiple items of the same type (determined through itemDetailId),
//	 * they are grouped.
//	 *
//	 * @param limit - unique no of items
//	 */
//	public function fetchRecentlyAdded($recentDayThreshold, $limit = null)
//	{
//		Debug::log('Item_model::fetchRecentlyAdded');
//		$query = 'SELECT count(a.itemDetailId) as count, a.description, a.productCode, a.itemDetailId, a.dateAdded '
//			   . 'FROM ( '
//   			   . '   SELECT id.description, id.productCode, id.itemDetailId, i.dateAdded '
//   			   . '   FROM Item i '
//   			   . '   JOIN ItemDetail id ON (i.itemDetailId = id.itemDetailId) '
//   			   . '   WHERE DATE_SUB(CURDATE(), INTERVAL ? DAY) <= i.dateAdded '
//   			   . '   ORDER BY i.dateAdded DESC '
//			   . ') AS a '
//			   . 'GROUP BY a.itemDetailId '
//			   . 'ORDER BY a.dateAdded DESC';
//		if (!empty($limit)) {
//			$query .= 'LIMIT ' . $limit;
//		}
//
//		$resultSet = $this->db->query($query, array($recentDayThreshold));
//		Debug::log($this->db->last_query());
//		return $resultSet->result_array();
//	}


	public function fetchAll()
	{

	}


	public function insert() {
		Debug::log($this);
		if (empty($this->productCode) ||
			empty($this->itemTypeId) ||
			empty($this->description)) {
			throw new InvalidArgumentException('Some required parameters are missing.');
		}
		$duplicateId = $this->_itemDuplicateExists();
		if ($duplicateId !== null) {
			throw new DuplicateRecordException('An item similar to the one being added already exists. [ItemId#' . $duplicateId . ']');
		}

		$this->db->insert(self::TBL_NAME, $this);
		return $this->db->insert_id();
	}

	private function _itemDuplicateExists() {
		$this->db->select('*')
			->from(self::TBL_NAME)
			->where('productCode', $this->productCode)
			->where('description', $this->description)
			->limit(1);
		$query = $this->db->get();
		$result = $query->row_array();
		Debug::log($this->db->last_query());
		if (!empty($result['itemId'])) {
			return $result['itemId'];
		}
		return null;
	}




}