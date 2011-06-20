<?php
class Supplier extends CI_Model
{
	public $name;
	public $discount;

	private $_name = 'Supplier';

	public function __construct()
	{
		$this->load->database();
		parent::__construct();
	}
}