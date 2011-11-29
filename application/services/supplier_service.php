<?php
class SupplierService extends MY_Service
{

	public $models = array(
		'supplier',
	);


	public function saveOrUpdate($data)
	{
		$supplier = new Supplier_model();
		$supplier->name = $data['supplier'];
		$supplier->address = $data['address'];
		$supplierId = null;
		if (empty($data['supplierId'])) {
			$supplierId = $supplier->insert();
		} else {
			$supplier->supplierId = $data['supplierId'];
			$supplier->update();
			$supplierId = $data['supplierId'];
		}
		return $supplierId;
	}


	public function fetchSuppliersForItem($itemId)
	{
		if (!$itemId) {
			throw new InvalidArgumentException('ItemId must be supplied.');
		}
		$this->db->select('s.*, ie.discount, ie.price')
			->from('ItemExpense ie')
			->join('Supplier s', 's.supplierId = ie.supplierId', 'left')
			->where('ie.ItemId', (int) $itemId)
			->where('ie.supplierId IS NOT NULL')
			->group_by(array('ie.supplierId', 'ie.discount'))
			->order_by('ie.supplierId')
			->order_by('ie.discount DESC');
		$query = $this->db->get();
		Debug::log($this->db->last_query());
		$results = $query->result_array();
		return $results;
	}


	public function fetchDetailed($supplierId = null)
	{
		if (empty($supplierId)) {
			return;
		}
		$this->db->select('*')
			->from('Supplier s')
			->where('s.supplierId', $supplierId);
		$query = $this->db->get();
		return $query->row_array();
	}


	public function fetchItemsSupplied($supplierId = null)
	{
		if (empty($supplierId))  {
			return;
		}
		$this->db->select('*')
			->from('ItemExpense ie')
			->join('Item i', 'i.itemId = ie.itemId')
			->where('supplierId', $supplierId)
			->group_by('ie.itemId');
		$query = $this->db->get();
		$items = $query->result_array();
		return $this->fetchPriceHistoryForItems($items);
	}


	public function fetchPriceHistoryForItems($items)
	{
		foreach ($items as $key => $item) {
			$this->db->select('ie.itemExpenseId, ie.price, ie.dateAdded')
				->from('ItemExpense ie')
				->where('ie.itemId', $item['itemId'])
				->order_by('ie.dateAdded DESC');
			$query = $this->db->get();
			$prices = $query->result_array();
			$items[$key]['prices'] = $prices;
		}
		return $items;
	}
}