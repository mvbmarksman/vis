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
				$itemService = new ItemService();
				if ($this->input->post('newItem') == 1) {
					$data['itemId'] = $itemService->saveItem($data);
				}

				// save the supplier data if there is one
				if ($this->input->post('supplier')) {
					$supplierService = new SupplierService();
					$data['supplierId'] = $supplierService->saveOrUpdate($data);
				}

				// create stock data
				$stockService = new StockService();
				$stockService->addItemToStore($data['itemId'], 1, $this->input->post('quantity')); // TODO hardcoded storeID

				// create item expense record
				$itemExpenseService = new ItemExpenseService();
				$itemExpenseService->saveItemExpense($data);

				// finally update the lastest buying price column
				$itemService->updateLatestBuyingPrice($data['itemId'], $data['price']);

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
				redirect('/expense/dailyexpense');
				exit;
			}
		}
		$itemTypeService = new ItemTypeService();
		$items = $itemTypeService->fetchAllItems();
		$this->renderView('inventoryexpenseform', array('itemTypes' => $items));
	}


	/**
	 * For now let's just show daily expense
	 */
	public function dailyexpense($dateParam = null)
	{
		$this->view->addCss('sales/summary.css');
		$itemExpenseService = new ItemExpenseService();

		$date = null;
		if (isset($dateParam)) {
			try {
				$dateObj = new DateTime($dateParam);
				$date = $dateObj->format('Y-m-d');
			} catch (Exception $e) {
				Debug::log('Invalid date supplied.', 'error');
			}
		}
		if ($date == null) {
			$date = date('Y-m-d');
		}

		$itemExpenses = $itemExpenseService->fetchItemExpenses(ItemExpenseService::DAILY, $date);
		Debug::log($itemExpenses);
		$this->renderView('dailyexpense', array(
			'itemExpenses' 	=> $itemExpenses,
			'date'	=> $date,
		));
	}


}
