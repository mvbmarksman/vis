<?php
class Sales_model extends CI_Model
{
	const TBL_NAME = 'Sales';

	public $salesId;
  	public $salesTransactionId;
  	public $itemDetailId;
  	public $sellingPrice;
  	public $qty;
  	public $discount;
  	public $storeId;
  	public $isVAT;


	public function insert()
	{
		if (empty($this->salesTransactionId)) {
			throw new IllegalArgumentsException('SalesTransactionId is empty.');
		}
		if (empty($this->itemDetailId)) {
			throw new IllegalArgumentsException('ItemDetailId is empty.');
		}
		if (empty($this->sellingPrice)) {
			throw new IllegalArgumentsException('SellingPrice is empty.');
		}
		if (empty($this->qty)) {
			throw new IllegalArgumentsException('Qty is empty.');
		}
		if (empty($this->storeId)) {
			throw new IllegalArgumentsException('StoreId is empty.');
		}
		$this->db->insert(self::TBL_NAME, $this);
		return $this->db->insert_id();
	}


	public function __toString()
	{
		return "SalesModel: salesId[$this->salesId], "
			. "salesTransactionId[$this->salesTransactionId], "
			. "itemDetailId[$this->itemDetailId], "
			. "sellingPrice[$this->sellingPrice], "
			. "qty[$this->qty], "
			. "discount[$this->discount], "
			. "storeId[$this->storeId], "
			. "isVAT[$this->isVAT], ";
	}
}