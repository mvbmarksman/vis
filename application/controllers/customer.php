<?php
class Customer extends MY_Controller
{
	public $services = array(
		'credit',
	);

	public function view($customerId = null)
	{
		$this->load->model('Customer_model', 'customerModel');
		$customerDetails = $this->customerModel->fetchById($customerId);
		$creditService = new CreditService();
		$creditsAndPayments = $creditService->fetchCreditsAndPaymentsForCustomer($customerId);

		if ($customerDetails == null) {
			$this->renderView('/common/general_error', array(
				'errorMessage'	=> "Oops, this customer does not exist.",
			));
			return;
		}

		Debug::log($creditsAndPayments);

		$this->renderView('view', array(
			'customer'				=> $customerDetails,
			'creditsAndPayments'	=> $creditsAndPayments,
		));
	}

}
