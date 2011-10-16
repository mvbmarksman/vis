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
		$recentlySoldItems = $salesTransactionService->fetchRecentlySold();
//		Debug::log($recentlySoldItems);

		$this->view->addCss('dashboard/index.css');
		$this->renderView('index', array(
			'itemsLowInStock'		=> $itemsLowInStock,
			'recentlyAddedItems'	=> $recentlyAddedItems,
			'recentlySoldItems'		=> $recentlySoldItems,
		));
	}




}