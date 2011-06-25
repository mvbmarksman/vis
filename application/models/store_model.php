<?php
class Store_model extends CI_Model
{
	public $storeId;
	public $name;
	public $location;

	private $_name = 'Store';

	public function __construct()
	{
		$this->load->database();
		parent::__construct();
	}
}