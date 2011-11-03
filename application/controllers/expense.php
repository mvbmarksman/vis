<?php
class Expense extends MY_Controller
{
	public $services = array(
		'supplier',
		'item_type',
		'item',
		'stock',
		'item_expense',
		'other_expense'
	);


	/**
	 * Creates and processes the inventory expense form
	 */
	public function inventoryexpenseform($newItemMode = null)
	{
		$this->view->addCss('expense/inventoryexpenseform.css');
		$this->view->addJs('jquery.validate.min.js');
		if ($this->input->post() != null) {
			$data = $this->input->post();
			Debug::log($data);
			try {
				$itemService = new ItemService();
				if ($this->input->post('newItem') == 1) {
					$data['itemId'] = $itemService->saveItem($data);
				}

				if ($this->input->post('supplier')) {
					$supplierService = new SupplierService();
					$data['supplierId'] = $supplierService->saveOrUpdate($data);
				}

				$stockService = new StockService();
				$stockService->addItemsToStore($data['itemId'], 1, $this->input->post('quantity')); // TODO hardcoded storeID

				$itemExpenseService = new ItemExpenseService();
				$itemExpenseService->saveItemExpense($data);

				$itemService->updateLatestBuyingPrice($data['itemId'], $data['price']);

			} catch (Exception $e) {
				Debug::log($e->getMessage(), 'error');
				$error = $e->getMessage();
				$this->message->set($error, 'error', TRUE);
				redirect('/expense/inventoryexpenseform');
				exit;
			}
			$this->_showMessageAndRedirect();
		}
		$itemTypeService = new ItemTypeService();
		$items = $itemTypeService->fetchAllItems();
		$this->renderView('inventoryexpenseform', array(
			'itemTypes' 	=> $items,
			'newItemMode'	=> $newItemMode,
		));
	}


	public function otherexpenseform()
	{
		$this->view->addCss('expense/inventoryexpenseform.css');
		$this->view->addJs('jquery.validate.min.js');

		if ($this->input->post() != null) {
			$data = $this->input->post();
			Debug::log($data);
			$otherExpenseService = new OtherExpenseService();
			$otherExpenseService->saveOtherExpense($data);
			$this->_showMessageAndRedirect();
		}
		$this->renderView('otherexpenseform', array());
	}


	private function _showMessageAndRedirect()
	{
		if ($this->input->post('addAnother') == 1) {
			$this->message->set('Successfully added item and expense record.', 'success', TRUE);
			redirect($this->uri->uri_string());
			exit;
		} else {
			redirect('/expense/dailyexpense');
			exit;
		}
	}


	/**
	 * For now let's just show daily expense
	 */
	public function dailyexpense($dateParam = null)
	{
		$this->view->addCss('sales/summary.css');
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

		$itemExpenseService = new ItemExpenseService();
		$itemExpenses = $itemExpenseService->fetchItemExpenses(ItemExpenseService::DAILY, $date);
		$otherExpenseService = new OtherExpenseService();
		$otherExpenses = $otherExpenseService->fetchOtherExpenses(OtherExpenseService::DAILY, $date);
		$this->renderView('dailyexpense', array(
			'itemExpenses' 	=> $itemExpenses,
			'otherExpenses'	=> $otherExpenses,
			'date'	=> $date,
		));
	}


}
