<?php
require_once APPPATH . 'exceptions/FlexigridException.php';

class Flexigrid {

	public static function create($items, $page, $total) {
		if (!$items) {
			throw new FlexigridException("Data array can't be empty");
		}

		$gridData = array();
		$gridData['page'] = $page;
		$gridData['total'] = $total;
		$gridData['rows'] = array();

		$index = 0;
		foreach($items as $item) {
			$index++;
			$gridData['rows'][$index]['cell'] = $item;
		}
		echo json_encode($gridData);
	}
}