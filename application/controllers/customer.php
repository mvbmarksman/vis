<?php
class Customer extends MY_Controller
{
	public $models = array(
		'customer_model',
	);

	public $libs = array(
		'view',
	);

	public function getcustomerautocompletedata() {
		$items = $this->customer_model->fetch();
		foreach ($items as $key => $item) {
			$items[$key]['label'] = $item['fullname'];
			$items[$key]['value'] = $item['fullname'];
		}
		echo json_encode($items);
	}
}