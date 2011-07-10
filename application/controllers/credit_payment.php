<?php
class Credit_payment extends MY_Controller {

	public function creditpaymentform() {
		$this->load->model('credit_detail_model');
		$creditDetails = $this->credit_detail_model->fetch();
		$this->renderView('creditpaymentform', array('creditDetails' => $creditDetails));
	}
}