<?php
class Supplier extends MY_Controller
{
	public $services = array(
		#'sales_transaction',
		#'item_detail',
		#'customer',
		#'sales',
		'supplier',
	);


	/**
	 * Gets the data needed for the items autocomplete input box.
	 * This function is called via an AJAX call.
	 *
	 * @return JSON
	 */
	public function getsuppliersforautocomplete()
	{
		$supplierService = new SupplierService();
		$suppliers = $supplierService->fetchAllItems();
		foreach ($suppliers as $key => $supplier) {
			$suppliers[$key]['label'] = $supplier['name'];
			$suppliers[$key]['value'] = $supplier['name'];
		}
		echo json_encode($suppliers);
	}


}
