<?php
class Sales extends MY_Controller
{
	public $libs = array('view');

	public $services = array(
		'sales_transaction',
		'item_detail',
		'customer',
		'sales',
	);

	/**
	 * Adds the dependencies needed by the sales form.
	 * Initializes the creditdetailsform partial.
	 */
	public function salesform()
	{
		$this->view->addCss('salesform.css');
		$this->view->addJs('salesform.js');
		$creditDetailsForm = $this->view->load('creditdetailsform', 'sales/_creditdetailsform', array());
		$this->renderView('salesform', array(
			'creditDetailsForm' => $creditDetailsForm)
		);
	}

	/**
	 * Gets the data needed for the items autocomplete input box.
	 * This function is called via an AJAX call.
	 *
	 * @return JSON
	 */
	public function getitemsforautocomplete()
	{
		$itemDetailService = new ItemDetailService();
		$items = $itemDetailService->fetchAllItems();
		foreach ($items as $key => $item) {
			$items[$key]['label'] = $item['description'];
			$items[$key]['value'] = $item['description'];
		}
		echo json_encode($items);
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
	 * Sales form handler
	 */
	public function processsalesform()
	{
		$data = $this->input->post();
		$customerService = new CustomerService();
		$customerId = $customerService->saveOrUpdate($data);
		$data['customerId'] = $customerId;

		$salesTransactionService = new SalesTransactionService();
		$salesTransactionId = $salesTransactionService->insert($data);
		$data['salesTransactionId'] = $salesTransactionId;

		$salesService = new SalesService();
		$salesObjs = $salesService->marshallSales($data);
		$salesObjs = $salesService->mergeSimilarItems($salesObjs);
		$data['totalPrice'] = $salesService->saveAndComputeTotal($salesObjs);
		$salesTransactionService->update($data);
		$this->load->helper('url');
		redirect('/sales/summary?transactionId=' . $salesTransactionId, 'refresh');
	}


	/**
	 * Builds the data structure that we need for displaying the transaction details
	 */
	public function summary()
	{
		$salesTransactionId = $this->input->get('transactionId');
		$salesTransactionService = new SalesTransactionService();
		$transactionDetails = $salesTransactionService->fetchDetailed($salesTransactionId);
		$this->renderView('summary', array('items' => $transactionDetails));
	}

}