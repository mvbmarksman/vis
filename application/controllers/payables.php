<?php
class Payables extends MY_Controller
{
	public $services = array(
		'payables',
		'supplier',
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
            $payables = $payablesService->fetchPayablesList();

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
}
