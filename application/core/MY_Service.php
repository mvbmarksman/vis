<?php
class MY_Service
{
	public $db;
	public $models = array();

	public function __construct() {
		foreach ($this->models as $model) {
			require_once APPPATH . 'models/' . $model . '_model.php';
		}
	}
}