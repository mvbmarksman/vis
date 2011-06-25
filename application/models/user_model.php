<?php
class User_model extends CI_Model
{
	public $userId;
	public $username;
	public $password;
	public $lastName;
	public $firstName;
	public $isAdmin;

	private $_name = 'User';

	public function __construct()
	{
		$this->load->database();
		parent::__construct();
	}
}