<?php
class Test extends MY_Controller {
	const MODEL = 'test_model';
	public function salesform() {

		$this->renderView('salesform', array());
	}
}