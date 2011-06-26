<?php
class Test extends MY_Controller {

	public function fetch() {
		$this->load->model('sales_transaction_model');
		$data = $this->sales_transaction_model->fetch();
		Debug::dump($data);
	}


	public function insert() {
		$this->load->model('sales_transaction_model');
		$obj = new Sales_transaction_model();
		$obj-> date = '2011-12-7';
        $obj-> userId =  2;
        $obj-> creditId =  3;
        $obj-> totalPrice =  19.00;
       	$obj-> isFullyPaid = 1;
		$lastInsertId = $this->sales_transaction_model->save($obj);
		$data = $this->sales_transaction_model->fetch($lastInsertId);
		Debug::dump($data);

	}

	public function update() {
		$this->load->model('sales_transaction_model');
		$obj = new Sales_transaction_model();
		$obj-> salesTransactionId = 31;
		$obj-> date = '2011-12-7';
        $obj-> userId =  1;
        $obj-> creditId =  1;
        $obj-> totalPrice =  19.00;
       	$obj-> isFullyPaid = 1;
        $lastInsertId = $this->sales_transaction_model->save($obj);
		$data = $this->sales_transaction_model->fetch($lastInsertId);
		Debug::dump($data);

	}
	public function delete(){
		$this->load->model('sales_transaction_model');
		$data = $this->sales_transaction_model->delete(32);
		$data = $this->sales_transaction_model->fetch();
		Debug::dump($data);

	}
}