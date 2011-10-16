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

		$query = 'SELECT id.itemDetailId, id.productCode, id.description, id.active, COUNT(i.itemDetailid) AS stock '
			   . 'FROM ItemDetail id '
			   . 'LEFT JOIN Item i ON (id.itemDetailId = i.itemDetailId) '
			   . 'GROUP BY i.itemDetailId '
			   . 'HAVING id.active = 1 AND stock <= ? '
			   . 'ORDER BY stock ';

		if (!empty($limit)) {
			$query .= 'LIMIT ' . $limit;
		}

		$resultSet = $this->db->query($query, array($lowStockThreshold));
		Debug::log($this->db->last_query());
		return $resultSet->result_array();
	}



	public function fetchRecentlyAdded($recentThreshold)
	{
		Debug::log('Item_model::fetchRecentlyAdded');
		$query = 'SELECT * '
			   . 'FROM ItemDetail '
			   . 'WHERE DATE_SUB(CURDATE(), INTERVAL ? DAY) <= dateAdded ';

		$resultSet = $this->db->query($query, array($recentThreshold));
		Debug::log($this->db->last_query());
		return $resultSet->result_array();
	}



}