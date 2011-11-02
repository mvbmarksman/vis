<?php
class Other_expense_model extends MY_Model
{
	const TBL_NAME = 'OtherExpense';

	public $description;
	public $price;
	public $payee;

	public function _checkArgs()
	{
		if (empty($this->description)) {
			throw new InvalidArgumentException('Description cannot be null.');
		}
		if (empty($this->price)) {
			throw new InvalidArgumentException('Price cannot be null.');
		}
		if (empty($this->payee)) {
			throw new InvalidArgumentException('Payee cannot be null.');
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