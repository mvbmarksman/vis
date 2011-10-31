<?php
class SupplierService extends MY_Service
{

	public $models = array(
		'supplier',
	);

	public function fetchAllItems()
	{
		$supplier = new Supplier_model();
		$suppliers = $supplier->fetchAll();
		return $suppliers;
	}

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
}
