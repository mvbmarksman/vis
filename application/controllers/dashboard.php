<?php
class Dashboard extends MY_Controller
{
	public $services = array(
		'item',
	);


	public function index()
	{
		// get items that are running low in quantity
		$itemService = new ItemService();
		$itemsLowInStock = $itemService->fetchLowInStock();
		Debug::dump($itemsLowInStock);
		
		$this->view->addCss('dashboard/index.css');
		$this->renderView('index', array());
	}
	
	


}