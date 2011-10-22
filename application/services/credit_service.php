<?php
class CreditService extends MY_Service
{

	public $models = array(
		'sales_transaction',
	);


	public function fetchOverdueCredits()
	{
		$salesTransaction = new Sales_transaction_model();
		return $salesTransaction->fetchOverdueCredits();
	}

}