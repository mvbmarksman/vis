<?php
class Supplier extends MY_Controller
{
	public $services = array(
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
		$this->load->model('Supplier_model', 'supplier');
		$suppliers = $this->supplier->fetchAll();
		foreach ($suppliers as $key => $supplier) {
			$suppliers[$key]['label'] = $supplier['name'];
			$suppliers[$key]['value'] = $supplier['name'];
		}
		echo json_encode($suppliers);
	}


	public function view($supplierId = null)
	{
		$supplierService = new SupplierService();
		$supplierDetails = $supplierService->fetchDetailed($supplierId);

		if ($supplierDetails == null) {
			$this->renderView('/common/general_error', array(
				'errorMessage'	=> "Oops, this supplier does not exist.",
			));
			return;
		}

		$itemsSupplied = $supplierService->fetchItemsSupplied($supplierId);
		Debug::show($itemsSupplied);
		$this->renderView('view', array(
			'supplier'			=> $supplierDetails,
			'itemsSupplied'		=> $itemsSupplied,
		));
	}


}
