<?php
class Expense extends MY_Controller
{
	public $services = array(
		'supplier',
		'item_type',
		'item',
		'stock',
		'item_expense'
	);


	/**
	 * Creates and processes the inventory expense form
	 */
	public function inventoryexpenseform()
	{
		$this->view->addCss('expense/inventoryexpenseform.css');
		$this->view->addJs('jquery.validate.min.js');

		if ($this->input->post() != null) {
			$data = $this->input->post();
			Debug::log($data);
			try {
				// save the item data if we're adding a new one
				if ($this->input->post('newItem') == 1) {
					$itemService = new ItemService();
					$data['itemId'] = $itemService->saveItem($data);
				}

				// save the supplier data if there is one
				if ($this->input->post('supplier')) {
					$supplierService = new SupplierService();
					$data['supplierId'] = $supplierService->saveOrUpdate($data);
				}

				$stockService = new StockService();
				$stockService->addItemToStore($data['itemId'], 1, $this->input->post('quantity')); // TODO hardcoded storeID

				// create item expense record
				$itemExpenseService = new ItemExpenseService();
				$itemExpenseService->saveItemExpense($data);

			} catch (Exception $e) {
				Debug::log($e->getMessage(), 'error');
				$error = $e->getMessage();
				$this->message->set($error, 'error', TRUE);
				redirect('/expense/inventoryexpenseform');
				exit;
			}

			if ($this->input->post('addAnother') == 1) {
				$this->message->set('Successfully added item and expense record.', 'success', TRUE);
				redirect('/expense/inventoryexpenseform');
				exit;
			} else {
				redirect('/expense/dailyreport');
				exit;
			}
		}
		$itemTypeService = new ItemTypeService();
		$items = $itemTypeService->fetchAllItems();
		$this->renderView('inventoryexpenseform', array('itemTypes' => $items));
	}
}
