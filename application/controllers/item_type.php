<?php
class Item_type extends MY_Controller
{
	public function show() {
		$this->load->model('item_type_model');
		$itemtypes = $this->item_type_model->fetch();
		Debug::dump($itemtypes);
	}
}