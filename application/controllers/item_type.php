<?php
class Item_type extends MY_Controller
{
	const MODEL = 'item_type_model';

	public function __construct() {
		$this->setModel(self::MODEL);
		parent::__construct();
	}

}