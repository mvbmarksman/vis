<?php
class Sales extends CI_Model
{

  	public $salesTransactionId;
  	public $itemDetailId;
  	public $unitPrice;
  	public $qty;
  	public $discount;
  	public $storeId;
  	public $isVAT;

	private $_name = 'Sales';

	public function __construct()
	{
		$this->load->database();
		parent::__construct();
	}
}