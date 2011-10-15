<?php
class Item_model extends MY_Model
{
	const TBL_NAME = 'Item';

	public $itemId;
	public $itemDetailId;
	public $storeId;

	
	public function fetchLowInStock($lowStockThreshold) {
		Debug::log('Item_model::fetchLowInStock');
		if (empty($lowStockThreshold)) {
			$lowStockThreshold = 0;
		}
		
		$query = 'SELECT COUNT(*) AS stock, id.itemDetailId, productCode, description, isUsed '
			   . 'FROM ItemDetail id '
			   . 'LEFT JOIN Item i ON (id.itemDetailId = i.itemDetailId) '
			   . 'GROUP BY i.itemDetailId '
			   . 'HAVING isUsed = 1 '
			   . 'AND stock >= ?';
			   
		$resultSet = $this->db->query($query, array($lowStockThreshold));
		Debug::log($this->db->last_query());
		return $resultSet->result_array();
	}
	
	
	
}