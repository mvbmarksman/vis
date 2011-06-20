<?php
class Expense extends CI_Model
{
	public $dailyExpenseTransactionId;
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