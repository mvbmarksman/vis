<?php
class Payables extends MY_Controller
{
	public $services = array(
		'payables',
	);


	public function listpayables()
	{
            $payablesService = new PayablesService();
            $payables = $payablesService->fetchPayablesList();
            $cookiePrefix = 'listpayables';

            /*
            $this->load->helper('my_filter');
            $filterInput = array(
                'show'      => $this->input->get('show_filter'),
                'fromDate'  => $this->input->get('fromDate_filter'),
                'toDate'    => $this->input->get('toDate_filter'),
            );
            $filterHelper = new My_filter_helper($filterInput, $cookiePrefix);
            $filterHelper->processAndStoreFilters();

            $creditService = new CreditService();
            $credits = $creditService->fetchCreditList(
                $filterHelper->get('show'),
                $filterHelper->get('fromDate'),
                $filterHelper->get('toDate')
            );
            */
            $this->renderView('listcredits', array(
                'credits'       => $credits,
                'cookiePrefix'  => $cookiePrefix,
//                'showFilter'    => $filterHelper->get('show'),
//                'fromDate'      => $filterHelper->get('fromDate'),
//                'toDate'        => $filterHelper->get('toDate'),
            ));

	}
}
