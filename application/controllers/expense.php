<?php
class Expense extends MY_Controller
{
	/*
	public $services = array(
		'sales_transaction',
		'item_detail',
		'customer',
		'sales',
	);
	*/

	/**
	 * Adds the dependencies needed by the sales form.
	 * Initializes the creditdetailsform partial.
	 */
	public function inventory()
	{
		$this->view->addCss('expense/inventory.css');
		$this->view->addJs('expense/inventory.js');
		$this->renderView('inventory', array());
	}
}
