<?php
class Sales_transaction extends MY_Controller {

	const MODEL = 'sales_transaction_model';

	public function __construct() {
		$this->setModel(self::MODEL);
		parent::__construct();
	}
}