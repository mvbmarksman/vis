<?php
class DailyExpenseTransaction extends CI_Model
{
	public $data;

	private $_name = 'DailyExpenseTransaction';

	public function __construct()
	{
		$this->load->database();
		parent::__construct();
	}
}
