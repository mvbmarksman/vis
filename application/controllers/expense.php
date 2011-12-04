<?php
class Expense extends MY_Controller
{
	public $services = array(
		'item_type',
		'category',
		'item_expense',
		'other_expense',
	);


	/**
	 * Creates and processes the inventory expense form
	 */
	public function inventoryexpenseform($newItemMode = null)
	{
		$this->view->addCss('expense/inventoryexpenseform.css');
		$this->view->addJs('jquery.validate.min.js');
		$itemTypes = array();
		$categories = array();
		if ($this->input->post() != null) {
			$data = $this->input->post();
			Debug::log($data);
			try {
				$itemExpenseService = new ItemExpenseService();
				$itemExpenseService->processItemExpenseForm($data);
			} catch (Exception $e) {
				Debug::log($e->getMessage(), 'error');
				$this->_showErrorMessageAndRedirect($e->getMessage());
			}
			$this->_showMessageAndRedirect();
		} else {
			$itemTypeService = new ItemTypeService();
			$itemTypes = $itemTypeService->fetchAllItems();
			$categoryService = new CategoryService();
			$categories = $categoryService->fetchAll();
		}

		$this->renderView('inventoryexpenseform', array(
			'itemTypes' 	=> $itemTypes,
			'categories'	=> $categories,
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
			$url = $this->uri->uri_string();

			if ($this->input->post('newItem') == 1) {
				$url .= '/1';	// set to newItemMode
			}
			Debug::log($url);
			redirect($url);
			exit;
		} else {
			redirect('/expense/dailyexpense');
			exit;
		}
	}

	private function _showErrorMessageAndRedirect($message)
	{
		$this->message->set($message, 'error', TRUE);
		$url = '/expense/inventoryexpenseform';
		if ($this->input->post('newItem') == 1) {
			$url .= '/1'; 		// set to newItemMode
		}
		redirect($url);
		exit;
	}


	/**
	 * For now let's just show daily expense
	 */
	public function dailyexpense($dateParam = null)
	{
        $this->load->helper('My_date_helper');
        $date = My_date_helper::getMysqlDate($dateParam);

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
