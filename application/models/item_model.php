<?php
class Item_model extends MY_Model
{
	const TBL_NAME = 'Item';

	public $itemId;
	public $itemDetailId;
	public $storeId;


	public function fetchLowInStock($lowStockThreshold, $limit = null)
	{
		Debug::log('Item_model::fetchLowInStock');
		if (empty($lowStockThreshold)) {
			$lowStockThreshold = 0;
		}

		$query = 'SELECT id.itemDetailId, id.productCode, id.description, id.active, COUNT(i.itemDetailid) AS count '
			   . 'FROM ItemDetail id '
			   . 'LEFT JOIN Item i ON (id.itemDetailId = i.itemDetailId) '
			   . 'GROUP BY i.itemDetailId '
			   . 'HAVING id.active = 1 AND count <= ? '
			   . 'ORDER BY count ';

		if (!empty($limit)) {
			$query .= 'LIMIT ' . $limit;
		}

		$resultSet = $this->db->query($query, array($lowStockThreshold));
		Debug::log($this->db->last_query());
		return $resultSet->result_array();
	}



	/**
	 * Fetches items that have been recently added (through purchase)
	 * If there are multiple items of the same type (determined through itemDetailId),
	 * they are grouped.
	 *
	 * @param limit - unique no of items
	 */
	public function fetchRecentlyAdded($recentDayThreshold, $limit = null)
	{
		Debug::log('Item_model::fetchRecentlyAdded');
		$query = 'SELECT count(a.itemDetailId) as count, a.description, a.productCode, a.itemDetailId, a.dateAdded '
			   . 'FROM ( '
   			   . '   SELECT id.description, id.productCode, id.itemDetailId, i.dateAdded '
   			   . '   FROM Item i '
   			   . '   JOIN ItemDetail id ON (i.itemDetailId = id.itemDetailId) '
   			   . '   WHERE DATE_SUB(CURDATE(), INTERVAL ? DAY) <= i.dateAdded '
   			   . '   ORDER BY i.dateAdded DESC '
			   . ') AS a '
			   . 'GROUP BY a.itemDetailId ';
		if (!empty($limit)) {
			$query .= 'LIMIT ' . $limit;
		}

		$resultSet = $this->db->query($query, array($recentDayThreshold));
		Debug::log($this->db->last_query());
		return $resultSet->result_array();
	}



}