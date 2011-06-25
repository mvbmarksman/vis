<?php
class Item_type extends MY_Controller
{
	const MODEL = 'item_type_model';

	public function showall() {
		$this->load->model(self::MODEL);
		$itemtypes = $this->item_type_model->fetch();
		$this->renderView('showall', array('data' => 5));
	}
}