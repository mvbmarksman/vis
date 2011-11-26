<?php
class Payables extends MY_Controller
{
	public $services = array(
		'payables',
		'supplier',
	);


	public function listpayables()
	{
            $payablesService = new PayablesService();
            $payables = $payablesService->fetchPayablesList();
            $cookiePrefix = 'listpayables';

            $this->load->helper('my_filter');
            $filterInput = array(
                'show'      => $this->input->get('show_filter'),
            	'supplier'	=> $this->input->get('supplier_filter'),
                'fromDate'  => $this->input->get('fromDate_filter'),
                'toDate'    => $this->input->get('toDate_filter'),
            );
            $filterHelper = new My_filter_helper($filterInput, $cookiePrefix);
            $filterHelper->processAndStoreFilters();

            $this->load->model('Supplier_model',  'supplier');
            $suppliers = $this->supplier->fetchAll();

            /*
            $creditService = new CreditService();
            $credits = $creditService->fetchCreditList(
                $filterHelper->get('show'),
                $filterHelper->get('fromDate'),
                $filterHelper->get('toDate')
            );
            */
            Debug::show($suppliers);
            Debug::show($payables);
            $this->renderView('listpayables', array(
                'payables'       	=> $payables,
                'cookiePrefix'  	=> $cookiePrefix,
            	'suppliers'			=> $suppliers,
                'showFilter'    	=> $filterHelper->get('show'),
            	'supplierFilter'	=> $filterHelper->get('supplier'),
                'fromDate'      	=> $filterHelper->get('fromDate'),
                'toDate'        	=> $filterHelper->get('toDate'),
            ));

	}
}
