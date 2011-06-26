<?php
class Test extends MY_Controller {
	const MODEL = 'item_type_model';
	public function salesform() {

		$this->renderView('salesform', array());
	}
}