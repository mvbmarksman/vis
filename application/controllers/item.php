<?php
class Item extends MY_Controller
{
	public $services = array(
		'item',
	);


	/**
	 * Gets the data needed for the items autocomplete input box.
	 * This function is called via an AJAX call.
	 *
	 * @return JSON
	 */
	public function getitemsforautocomplete()
	{
		$itemService = new ItemService();
		$items = $itemService->fetchItemsForAutocomplete();
		echo json_encode($items);
	}


}