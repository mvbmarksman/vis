<?php
class Credit_payment extends MY_Controller {

	public function showform() {
		$this->load->model('credit_detail_model');
		$creditDetails = $this->credit_detail_model->fetch();
		$this->renderView('showform', array('creditDetails' => $creditDetails));
	}


	public function getcreditdetail() {
		$creditDetailId = $this->input->post('creditDetailId');
		$this->load->library('view');

		// TODO query details
		$data['name'] = 'Mark';

		$contents = $this->view->load('creditdetails', 'credit_payment/creditdetails', array('data' => $data));
		echo $contents;
	}
}