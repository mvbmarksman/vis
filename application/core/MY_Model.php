<?php
class MY_Model extends CI_Model
{
	public function __construct() {
		require_once APPPATH . 'core/IAbstractDAO.php';
		require_once APPPATH . 'exceptions/DAOException.php';
		$this->load->database();
		parent::__construct();
	}
}