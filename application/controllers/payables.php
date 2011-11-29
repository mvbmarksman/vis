<?php
class Payables extends MY_Controller
{
	public $services = array(
		'payables',
		'supplier',
		'item_expense',
	);


	public function listpayables()
	{
		$this->load->model('Supplier_model',  'supplier');
		$suppliers = $this->supplier->fetchAll();

		$cookiePrefix = 'listpayables';
		$this->load->helper('my_filter');
		$filterHelper = new My_filter_helper($cookiePrefix, 'filter');

		$showFilter = $filterHelper->storeAndGet('show');
		$supplierFilter = $filterHelper->storeAndGet('supplier');
		$fromDateFilter = $filterHelper->storeAndGet('fromDate');
		$toDateFilter = $filterHelper->storeAndGet('toDate');

		$payablesService = new PayablesService();
		$payables = $payablesService->fetchPayablesList($showFilter, $fromDateFilter, $toDateFilter, $supplierFilter);

		$this->renderView('listpayables', array(
			'payables'       	=> $payables,
			'cookiePrefix'  	=> $cookiePrefix,
			'suppliers'			=> $suppliers,
			'showFilter'    	=> $showFilter,
			'supplierFilter'	=> $supplierFilter,
			'fromDate'      	=> $fromDateFilter,
			'toDate'        	=> $toDateFilter,
		));
	}


	public function flagaspaid()
	{
		$itemExpenseId = $this->input->post('id');
		try {
			$itemExpenseService = new ItemExpenseService();
			$itemExpenseService->flagAsPaid($itemExpenseId);
		} catch (Exception $e) {
			$this->message->set('Unable to flag transaction as paid. Error: ' . $e->getMessage(), 'error', TRUE);
			return;
		}
		$this->message->set('Successfully flagged transaction as paid.', 'success', TRUE);
	}
}
