<?php
class Items extends MY_Controller
{
	public $models = array(
		'item_detail_model',
		'item_model',
		'store_model',
	);

	public $libs = array(
		'view',
	);

	public function transferform() {
		$itemDetails = $this->item_detail_model->fetch();
		$storeDetails = $this->store_model->fetch();
		$this->renderView('transferform', array(
							'itemDetails' => $itemDetails,
							'storeDetails' => $storeDetails));
	}

	public function processtransfer(){
		$this->item_model->updateitems($this->input->post());
		debug::dump('success');
	}
}