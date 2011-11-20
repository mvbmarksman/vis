<?php
class Item_model extends MY_Model
{
	public $itemId;
	public $productCode;
	public $description;
	public $itemTypeId;
	public $categoryId;
	public $suggestedSellingPrice;
	public $dateAdded;
	public $active;


	public function __construct()
	{
		parent::__construct();
		$this->setName('Item');
	}


	protected function _checkArgs()
	{
		if (empty($this->productCode)) {
			throw new InvalidArgumentException('Product code cannot be empty.');
		}
		if (empty($this->itemTypeId)) {
			throw new InvalidArgumentException('ItemTypeId cannot be empty.');
		}
		if (empty($this->categoryId)) {
			throw new InvalidArgumentException('CategoryId cannot be empty.');
		}
		if (empty($this->description)) {
			throw new InvalidArgumentException('Description cannot be empty.');
		}
	}
}