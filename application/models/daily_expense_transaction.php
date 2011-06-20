<?php
class DailyExpenseTransaction extends CI_Model
{
	public $dailyExpenseTransactionId;
	public $date;

	private $_name = 'DailyExpenseTransaction';

	public function __construct()
	{
		$this->load->database();
		parent::__construct();
	}
}
