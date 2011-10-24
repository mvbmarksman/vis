<?php
class SupplierService extends MY_Service
{

	public $models = array(
		'supplier'
	);


	public function fetchAllItems()
	{
		$supplier = new Supplier_model(); 
		$suppliers = $supplier->fetchAll();
		return $suppliers;
	}
}
