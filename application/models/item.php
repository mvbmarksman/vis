<?php
class Item extends CI_Model
{
	public $itemDetailId;
	public $storeId;

	private $_name = 'Item';

	public function __construct()
	{
		$this->load->database();
		parent::__construct();
	}
}