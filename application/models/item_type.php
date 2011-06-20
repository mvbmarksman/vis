<?php
class ItemType extends CI_Model
{
	public $itemTypeId;
	public $name;

	private $_name = 'ItemType';

	public function __construct()
	{
		$this->load->database();
		parent::__construct();
	}
}
