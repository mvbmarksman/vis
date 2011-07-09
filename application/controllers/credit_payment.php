<?php
class Sales extends MY_Controller {

	public function salesform() {
		$this->load->model('item_detail_model');
		$this->load->model('sales_model');
		$this->load->model('item_model');
		$itemDetails = $this->item_detail_model->fetch();
		$this->renderView('salesform', array('itemDetails' => $itemDetails));
	}
}