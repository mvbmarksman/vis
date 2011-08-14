<?php
class Admin_customer extends MY_Controller
{
	public $libs = array('view');

	public $services = array(
		'customer',
	);
	public function add()
	{
		$creditDetailsForm = $this->view->load('creditdetailsform', 'sales/_creditdetailsform', array());
		$this->renderView('add',null);
	}

	public function addcustomer()
	{

		$data = $this->input->post();
		$customerService = new CustomerService();
		$customerId = $customerService->saveOrUpdate($data);
		$data['customerId'] = $customerId;
	}

}