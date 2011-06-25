<?php
class Expense_model extends CI_Model
{
	public $expenseId;
	public $expenseTransactionId;
	public $description;
	public $price;
	public $disburser;

	private $_name = 'Expense';

	public function __construct()
	{
		$this->load->database();
		parent::__construct();
	}
}