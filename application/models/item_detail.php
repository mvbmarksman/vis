<?php
class ItemDetail extends CI_Model
{
	public $itemDetailId;
	public $itemDetail;
	public $productCode;
	public $itemTypeId;
	public $description;
	public $unit;
	public $buyingPrice;
	public $isUsed;
	public $sellingPrice;
	public $supplierId;

	private $_name = 'ItemDetail';

	public function __construct()
	{
		$this->load->database();
		parent::__construct();
	}
}
