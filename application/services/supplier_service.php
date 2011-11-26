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
}
