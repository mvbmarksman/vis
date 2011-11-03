<?php
class Dashboard extends MY_Controller
{
	public $services = array(
		'sales_transaction',
		'credit',
		'stock',
	);


	public function index()
	{
		$stockService = new StockService();
		$itemsLowInStock = $stockService->fetchLowInStock();

//		$recentlyAddedItems = $itemService->fetchRecentlyAdded();
		$recentlyAddedItems = array();
		$recentSalesTransactions = array();
		$overdueCredits = array();
//		$salesTransactionService = new SalesTransactionService();
//		$recentSalesTransactions = $salesTransactionService->fetchRecent();
//
//		$creditService = new CreditService();
//		$overdueCredits = $creditService->fetchOverdueCredits();

		$this->view->addCss('dashboard/index.css');
		$this->renderView('index', array(
			'itemsLowInStock'			=> $itemsLowInStock,
			'recentlyAddedItems'		=> $recentlyAddedItems,
			'recentSalesTransactions'	=> $recentSalesTransactions,
			'overdueCredits'			=> $overdueCredits,
		));
	}


}