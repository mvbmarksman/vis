<?php
class Item_detail extends MY_Controller
{
	public $services = array(
		'item_detail',
	);


	public function view($itemDetailId)
	{
		$itemDetailService = new ItemDetailService();
		try {
			$itemDetails = $itemDetailService->fetchById($itemDetailId);
		} catch (Exception $e) {
			Debug::log($e->getMessage(), 'error');
			echo $e->getMessage();
			redirect('/dashboard');
			exit;
		}
		$this->renderView('view', array(
			'item' => $itemDetails,
		));
	}


}