<?php
class Item_model extends CI_Model
{
	public $itemId;
	public $itemDetailId;
	public $storeId;

	private $_name = 'Item';

	public function __construct()
	{
		$this->load->database();
		parent::__construct();
	}
}