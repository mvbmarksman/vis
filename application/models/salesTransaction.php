<?php
class SalesTransaction extends CI_Model
{
	public $date;
	public $userId;
	public $creditId;
	public $totalPrice;
	public $isFullyPaid;

	private $_name = 'SalesTransaction';

	public function __construct()
	{
		$this->load->database();
		parent::__construct();
	}
}