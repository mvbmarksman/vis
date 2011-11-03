<?php
class Sales extends MY_Controller
{
	public $services = array(
		'sales_transaction',
		'stock',
		'customer',
		'sales'
	);

	/**
	 * Adds the dependencies needed by the sales form.
	 * Initializes the creditdetailsform partial.
	 */
	public function salesform()
	{
		$this->view->addCss('salesform.css');
		$this->view->addJs('salesform.js');
		$this->view->addJs('jquery.validate.min.js');

		if ($this->input->post()) {
			$data = $this->input->post();
			try {
				$salesService = new SalesService();
				$salesTransactionId = $salesService->processSalesForm($data);

			} catch (Exception $e) {
				Debug::log($e->getMessage(), 'error');
				$this->message->set($e->getMessage(), 'error', TRUE);
				redirect('/sales/salesform');
				exit;
			}
			$this->load->helper('url');
			redirect('/sales/summary/' . $salesTransactionId, 'refresh');
			exit;
		}
		$this->renderView('salesform', array());
	}

	/**
	 * Gets the data needed for the customer autocomplete input box.
	 * This function is called via an AJAX call.
	 *
	 * @return JSON
	 */
	public function getcustomersforautocomplete()
	{
		$customerService = new CustomerService();
		$items = $customerService->fetchAllItems();
		foreach ($items as $key => $item) {
			$items[$key]['label'] = $item['fullname'];
			$items[$key]['value'] = $item['fullname'];
		}
		echo json_encode($items);
	}


	/**
	 * Builds the data structure that we need for displaying the transaction details
	 */
	public function summary($salesTransactionId = null)
	{
		$this->view->addCss('sales/summary.css');
		$salesTransactionService = new SalesTransactionService();
		$transactionDetails = $salesTransactionService->fetchDetailed($salesTransactionId);
		Debug::log($transactionDetails);
		$this->renderView('summary', array('items' => $transactionDetails));
	}

}
