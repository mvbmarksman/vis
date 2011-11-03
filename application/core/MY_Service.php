<?php
class MY_Service
{
	public $models = array();
	public $services = array();
	public $db;

	public function __construct() {
		$this->load =& load_class('Loader', 'core');
		$this->load->database();
		$CI =& get_instance();
		$this->db = $CI->db;

		foreach ($this->models as $model) {
			require_once(APPPATH . 'models/' . $model . '_model.php');
		}

		foreach ($this->services as $service) {
			require_once(APPPATH . 'services/' . $service . '_service.php');
		}
	}
}