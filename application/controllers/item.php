<?php
class Item extends MY_Controller
{
	public $services = array(
		'item',
		'supplier',
		'item_expense'
	);


	/**
	 * Gets the data needed for the items autocomplete input box.
	 * This function is called via an AJAX call.
	 *
	 * @return JSON
	 */
	public function getitemsforautocomplete()
	{
		$itemService = new ItemService();
		$items = $itemService->fetchItemsForAutocomplete();
		echo json_encode($items);
	}


	/**
	 * Shows a detailed view of the item
	 */
	public function view($itemId)
	{
		try {
			$itemService = new ItemService();
			$item = $itemService->fetchDetailed($itemId);

			$supplierService = new SupplierService();
			$suppliers = $supplierService->fetchSuppliersForItem($itemId);

			$itemExpenseService = new ItemExpenseService();
			$buyingPrices = $itemExpenseService->fetchBuyingPricesForItem($itemId);

		} catch (Exception $e) {
			Debug::log($e->getMessage(), 'error');
			redirect('/dashboard');
			exit;
		}
		$this->renderView('view', array(
			'item' 			=> $item,
			'suppliers' 	=> $suppliers,
			'buyingPrices'	=> $buyingPrices,
		));
	}

}