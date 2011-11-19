<?php
class Customer extends MY_Controller
{
	public $services = array(
		'customer'
	);


	public function view($customerId)
	{
		$customerDetails = null;
		if (!empty($customerId)) {
			$customerService = new CustomerService();
			$customerDetails = $customerService->fetchDetails($customerId);
		}
		$this->renderView('view', array(
			'customer'	=> $customerDetails,
		));
	}

}
