<?php
class Credit extends CI_Model
{
	public $fullName;
	public $address;
	public $phoneNo;
	public $amountPaid;

	private $_name = 'Credit';

	public function __construct()
	{
		$this->load->database();
		parent::__construct();
	}
}