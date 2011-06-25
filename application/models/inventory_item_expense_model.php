<?php
class Inventory_item_expense_mode extends CI_Model
{
	public $inventoryItemExpense;
	public $expenseTransactionID;
	public $itemDetailId;
	public $unitPrice;
	public $qty;
	public $disburser;

	private $_name = 'InventoryExpenseTransaction';

	public function __construct()
	{
		$this->load->database();
		parent::__construct();
	}
}