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

		$this->_saveReferer();
		$this->renderView('creditpaymentform', array(
			'transactionDetails'	=> $salesTransactionDetails,
		));
	}


	private function _saveReferer()
	{
		if (empty($_SERVER['HTTP_REFERER'])) {
			return;
		}
		$this->load->helper('url');
		$referer = $_SERVER['HTTP_REFERER'];
		$uri = str_replace(base_url(), '', $referer);
		$this->session->set_userdata('creditpayment_referer', $uri);
	}


	public function processcreditpaymentform()
	{
		$creditService = new CreditService();
		try {
			$creditService->addCreditPayment($this->input->post());
			$this->message->set('Successfully added credit payment.', 'success', TRUE);
		} catch (Exception $e) {
			$this->message->set($e->getMessage(), 'error', TRUE);
			$url = '/credit/creditpaymentform/' . $this->input->post('salesTransactionId');
			redirect($url);
			exit;
		}

		$redirectUrl = '/credit/listcredits';
		$sessionData = $this->session->all_userdata();
		$referer = !empty($sessionData['creditpayment_referer']) ? $sessionData['creditpayment_referer'] : null;
		Debug::log($referer);
		if (!empty($referer)) {
			if (strstr($referer, 'customer/view/')) {
				$redirectUrl = '/' . $referer;
			}
		}
		redirect($redirectUrl);
		exit;
	}
}
