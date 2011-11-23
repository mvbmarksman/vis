<?php
class Credit extends MY_Controller
{
	public $services = array(
		'credit',
	);


	public function listcredits()
	{
            $this->load->helper('my_filter');
            $filterInput = array(
                'show'      => $this->input->get('show_filter'),
                'fromDate'  => $this->input->get('fromDate_filter'),
                'toDate'    => $this->input->get('toDate_filter'),
            );
            $filterHelper = new My_filter_helper($filterInput, 'listcredits');
            $filterHelper->processAndStoreFilters();

            $creditService = new CreditService();
            $credits = $creditService->fetchCreditList(
                $filterHelper->get('show'),
                $filterHelper->get('fromDate'),
                $filterHelper->get('toDate')
            );

            $this->renderView('listcredits', array(
                'credits' => $credits,
                'showFilter' => $filterHelper->get('show'),
                'fromDate' => $filterHelper->get('fromDate'),
                'toDate' => $filterHelper->get('toDate'),
            ));
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
		redirect('/credit/listcredits');
		exit;
	}
}
