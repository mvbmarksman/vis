<?php
class Dashboard extends MY_Controller
{
	public $services = array(
		'item',
		'sales_transaction',
	);


	public function index()
	{
		// get items that are running low in quantity
		$itemService = new ItemService();
		$itemsLowInStock = $itemService->fetchLowInStock();
//		Debug::log($itemsLowInStock);

		$recentlyAddedItems = $itemService->fetchRecentlyAdded();
//		Debug::log($recentlyAddedItems);

		$salesTransactionService = new SalesTransactionService();
		$recentSalesTransactions = $salesTransactionService->fetchRecent();
		Debug::log($recentSalesTransactions);

		$this->view->addCss('dashboard/index.css');
		$this->renderView('index', array(
			'itemsLowInStock'			=> $itemsLowInStock,
			'recentlyAddedItems'		=> $recentlyAddedItems,
			'recentSalesTransactions'	=> $recentSalesTransactions,
		));
	}


}