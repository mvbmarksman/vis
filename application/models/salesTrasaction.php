<?php
class SalesTrasaction extends CI_Model
{
	public $date;
	public $userId;
	public $creditId;
	public $totalPrice;
	public $isFullyPaid;

	private $_name = 'SalesTrasaction';

	public function __construct()
	{
		$this->load->database();
		parent::__construct();
	}
}