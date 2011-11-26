<?php
class Credit extends MY_Controller
{
	public $services = array(
		'credit',
	);


	public function listcredits()
	{
            $cookiePrefix = 'listcredits';
            $this->load->helper('my_filter');
            $filterHelper = new My_filter_helper($cookiePrefix, 'filter');
            $showFilter = $filterHelper->storeAndGet('show');
            $fromDateFilter = $filterHelper->storeAndGet('fromDate');
            $toDateFilter = $filterHelper->storeAndGet('toDate');

            Debug::show($showFilter);
            Debug::show($fromDateFilter);
            Debug::show($toDateFilter);


            $creditService = new CreditService();
            $credits = $creditService->fetchCreditList($showFilter, $fromDateFilter, $toDateFilter);

            $this->renderView('listcredits', array(
                'credits'       => $credits,
                'showFilter'    => $showFilter,
                'fromDate'      => $fromDateFilter,
                'toDate'        => $toDateFilter,
                'cookiePrefix'  => $cookiePrefix,
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
