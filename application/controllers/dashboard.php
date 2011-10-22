<?php
class Dashboard extends MY_Controller
{
	public $services = array(
		'item',
		'sales_transaction',
		'credit',
	);


	public function index()
	{
		$itemService = new ItemService();
		$itemsLowInStock = $itemService->fetchLowInStock();

		$recentlyAddedItems = $itemService->fetchRecentlyAdded();

		$salesTransactionService = new SalesTransactionService();
		$recentSalesTransactions = $salesTransactionService->fetchRecent();

		$creditService = new CreditService();
		$overdueCredits = $creditService->fetchOverdueCredits();

		$this->view->addCss('dashboard/index.css');
		$this->renderView('index', array(
			'itemsLowInStock'			=> $itemsLowInStock,
			'recentlyAddedItems'		=> $recentlyAddedItems,
			'recentSalesTransactions'	=> $recentSalesTransactions,
			'overdueCredits'			=> $overdueCredits,
		));
	}


}