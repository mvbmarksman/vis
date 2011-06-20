<?php
class InventoryExpenseTransaction extends CI_Model
{
	public $inventoryItemExpense;
	public $dailyExpenseTransactionID;
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