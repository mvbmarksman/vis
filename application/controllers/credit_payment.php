<?php
class Credit_payment extends MY_Controller {

	public function showform() {
		$this->load->model('credit_detail_model');
		$creditDetails = $this->credit_detail_model->fetch();
		$this->renderView('showform', array('creditDetails' => $creditDetails));
	}


	public function getcreditdetail() {
		$creditDetailId = $this->input->post('creditDetailId');
		$this->load->model('credit_detail_model');
		$this->load->model('sales_transaction_model');
		$this->load->model('credit_payment_model');
		$this->load->library('view');

		// TODO query details
		$creditDetail = $this->credit_detail_model->fetch($creditDetailId);
		$transactionDetails = $this->sales_transaction_model->gettransactiondetail($creditDetailId);
		$paymentDetails = $this->credit_payment_model -> getpaymentdetails($creditDetailId);
		$content = $this->view->load('creditdetails', 'credit_payment/creditdetails', array(
			'creditDetail' 			=> $creditDetail,
			'transactionDetails' 	=> $transactionDetails,
			'paymentDetails'		=> $paymentDetails
		));
		$this->view->render();
	}
}