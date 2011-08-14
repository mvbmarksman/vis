<?php
class Credit_payment extends MY_Controller
{
	public $libs = array('view');

	public $services = array(
		'customer',
//		'credit_payment',
	);

	public function details()
	{
		$customerId = $this->input->get('customerId');
		$this->renderView('details', array($customerId));
	}


	public function getcustomersforautocomplete()
	{
		$customerService = new CustomerService();
		$items = $customerService->fetchCustomersWithCredit();
		foreach ($items as $key => $item) {
			$items[$key]['label'] = $item['fullname'];
			$items[$key]['value'] = $item['fullname'];
		}
		echo json_encode($items);
	}


	public function detailsforcustomer() {
		$customerId = $this->input->post('customerId');
		$customerService = new CustomerService();
		$details = $customerService->fetchCustomersWithCredit();
		$this->renderAjaxView('detailsforcustomer', array('details' => $details));
	}
}