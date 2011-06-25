<?php
class Test extends MY_Controller {

	public function fetch() {
		$this->load->model('item_type_model');
		$data = $this->item_type_model->fetch(9);
		Debug::dump($data);
	}


	public function insert() {
		$this->load->model('item_type_model');
		$obj = new Item_type_model();
		$obj->name = "mark";
		$lastInsertId = $this->item_type_model->save($obj);
		$data = $this->item_type_model->fetch($lastInsertId);
		Debug::dump($data);

	}

	public function update() {
		$this->load->model('item_type_model');
		$obj = new Item_type_model();
		$obj->itemTypeId = 2;
		$obj->name = "---";

		$lastInsertId = $this->item_type_model->save($obj);
		$data = $this->item_type_model->fetch($lastInsertId);
		Debug::dump($data);
	}
}