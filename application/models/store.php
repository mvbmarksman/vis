<?php
class Store extends CI_Model
{
	public $name;
	public $location;

	private $_name = 'Store';

	public function __construct()
	{
		$this->load->database();
		parent::__construct();
	}
}