<?php
class Item_type extends MY_Controller
{
	const MODEL = 'item_type_model';



	public function showall() {
		$this->load->model(self::MODEL);
		$itemtypes = $this->item_type_model->fetch();
//		Debug::dump($itemtypes);
		$this->renderView('showall', array('gridData' => json_encode($itemtypes)));
	}




	public function getdata() {
		$this->load->model(self::MODEL);
		$itemtypes = $this->item_type_model->fetch();

//		$this->load->library('flexigrid');
//		$this->flexigrid->create($data);

		$data['page'] = 1;
		$data['total'] = 2;
		$data['rows'] = array();
		$i = 0;
		foreach($itemtypes as $itemtype) {
			$i++;
			$cells = array(
				'itemTypeId'	=> $itemtype['itemTypeId'],
				'name'			=> $itemtype['name'],
			);
			$data['rows'][$i]['cell'] = $cells;
		}

		echo json_encode($data);
	}
}