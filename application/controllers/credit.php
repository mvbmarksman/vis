<?php
class Credit extends MY_Controller
{
	public $services = array(
		'credit',
	);


	public function listcredits()
	{
		$this->view->addJs('jquery.cookie.js');
		$creditService = new CreditService();
		$credits = $creditService->fetchOverdueList(); 		// TODO
		$this->renderView('listcredits', array('credits' => $credits));
	}


	public function creditpaymentform($salesTransactionId = null)
	{
		$this->view->addJs('jquery.validate.min.js');
		$this->load->model('Sales_transaction_model', 'salesTransactionModel');
		$salesTransactionDetails = $this->salesTransactionModel->fetchById($salesTransactionId);

		if ($salesTransactionDetails == null) {
			$this->renderView('/common/general_error', array(
				'errorMessage'	=> "Oops, the transaction specified does not exist.",
			));
			return;
		}

		if ($salesTransactionDetails['isFullyPaid'] == 1) {
			$this->renderView('/common/general_error', array(
				'errorMessage'	=> "This credit has already been fully paid.",
			));
			return;
		}


		$this->renderView('creditpaymentform', array(
			'transactionDetails'	=> $salesTransactionDetails,
		));
	}


	public function processcreditpaymentform()
	{
		$creditService = new CreditService();
		try {
			$creditService->addCreditPayment($this->input->post());
		} catch (Exception $e) {
			$this->message->set($e->getMessage(), 'error', TRUE);
			$url = '/credit/creditpaymentform/' . $this->input->post('salesTransactionId');
			redirect($url);
			exit;
		}
		redirect('/credit/overduecredits');
		exit;
	}
}
