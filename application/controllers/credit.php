<?php
class Credit extends MY_Controller
{
	public $services = array(
		'credit',
	);


	public function listcredits()
	{
                $showFilter = $this->_getAndStoreFilter('showFilter');
                $fromDate = $this->_getAndStoreFilter('fromDate');
                $toDate = $this->_getAndStoreFilter('toDate');

                $creditService = new CreditService();
                $credits = $creditService->fetchCreditList(
                    $showFilter,
                    $fromDate,
                    $toDate
                );

		$this->renderView('listcredits', array(
                    'credits' => $credits,
                    'showFilter' => $showFilter,
                    'fromDate' => $fromDate,
                    'toDate' => $toDate,

                ));
	}


        /**
         * Try to get the value from the input.
         * If found, update the value in the cookie.
         * Otherwise try to get the value from the cookie.
         * If still unsuccessful, returns null.
         */
        private function _getAndStoreFilter($name)
        {
            $val = $this->input->get($name);
            if (!empty($val)) {
                Debug::log($name);
                Debug::log('input parameter found. setting cookie');
                $cookie = array(
                    'name'   => $name,
                    'value'  => $val,
                    'expire' => 604800, // 1 week
                    'host' => 'local.vis.com',
                    'path'   => '/',
                    'prefix' => 'filter_',
                );
                $this->input->set_cookie($cookie);
                return $val;
            } else {
                $val = $this->input->cookie('filter_' . $name);
                if (!empty($val)) {
                    return $val;
                }
            }
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
