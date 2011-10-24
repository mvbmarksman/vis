<?php
class Expense extends MY_Controller
{
	public $services = array(
		#'sales_transaction',
		#'item_detail',
		#'customer',
		#'sales',
		'supplier',
	);

	/**
	 * Adds the dependencies needed by the sales form.
	 * Initializes the creditdetailsform partial.
	 */
	public function inventoryexpenseform()
	{
		$this->view->addCss('expense/inventoryexpenseform.css');
		$this->view->addJs('jquery.validate.min.js');
		$this->renderView('inventoryexpenseform', array());
	}


	public function processinventoryexpenseform()
	{
		$data = $this->input->post();
		Debug::dump($data);
		$supplierService = new SupplierService();
		$supplierService->createOrUpdate($data);

		// create supplier record
		// create InventoryItemExpense record
		// create record in Item
	}
}
