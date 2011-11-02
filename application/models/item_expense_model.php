<?php
class Item_expense_model extends MY_Model
{
	const TBL_NAME = 'ItemExpense';

	public $itemId;
	public $price;
	public $quantity;
	public $supplierId;
	public $discount;
	public $isCredit;
	public $isFullyPaid;
	public $userId;


	public function _checkArgs()
	{
		if (empty($this->itemId)) {
			throw new InvalidArgumentException('ItemId cannot be null.');
		}
		if (empty($this->price)) {
			throw new InvalidArgumentException('Price cannot be null.');
		}
		if (empty($this->quantity)) {
			throw new InvalidArgumentException('Quantity cannot be null.');
		}
		if (!isset($this->isCredit)) {
			throw new InvalidArgumentException('IsCredit cannot be null.');
		}
		if (empty($this->userId)) {
			throw new InvalidArgumentException('UserId cannot be null.');
		}
	}

	public function insert() {
		Debug::log($this);
		$this->_checkArgs();
		$this->db->insert(self::TBL_NAME, $this);
		Debug::log($this->db->last_query());
		return $this->db->insert_id();
	}

}