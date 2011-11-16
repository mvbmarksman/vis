<?php
class Credit extends MY_Controller
{
	public $services = array(
		'credit',
	);


	public function overduecredits()
	{
		$creditService = new CreditService();
		$overdueCredits = $creditService->fetchOverdueList();
		$this->renderView('overduecredits', array('overdueCredits' => $overdueCredits));
	}
}
