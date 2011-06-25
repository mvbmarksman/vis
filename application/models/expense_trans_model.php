<?php
class Expense_trans_model extends CI_Model
{
	public $expenseTransactionId;
	public $date;

	private $_name = 'ExpenseTransaction';

	public function __construct()
	{
		$this->load->database();
		parent::__construct();
	}
}
