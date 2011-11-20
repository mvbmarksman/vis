<?php
class Sales_model extends My_Model
{
	public $salesId;
  	public $salesTransactionId;
  	public $itemId;
  	public $sellingPrice;
  	public $qty;
  	public $discount;
  	public $subTotal;
  	public $vatable;
  	public $vat;


	public function __construct()
	{
		parent::__construct();
		$this->setName('Sales');
	}


  	protected function _checkArgs()
  	{
  		if (empty($this->salesTransactionId)) {
			throw new IllegalArgumentsException('SalesTransactionId is empty.');
		}
		if (empty($this->itemId)) {
			throw new IllegalArgumentsException('ItemId is empty.');
		}
		if (empty($this->sellingPrice)) {
			throw new IllegalArgumentsException('SellingPrice is empty.');
		}
		if (empty($this->qty)) {
			throw new IllegalArgumentsException('Qty is empty.');
		}
  	}


	public function insert()
	{
		Debug::log($this);
		$this->_checkArgs();
		$this->db->insert($this->_name, $this);
		return $this->db->insert_id();
	}

}