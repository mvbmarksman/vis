<?php
class Sales_transaction extends CI_Model
{
	public $salesTransactionId;
	public $date;
	public $userId;
	public $creditId;
	public $totalPrice;
	public $isFullyPaid;

	private $_name = 'Sales_transaction';

	public function __construct()
	{
		$this->load->database();
		parent::__construct();
	}

	public function insert(){
		$this->load->model('sales_model');

		$this->input->post('fisVAT') == 'on' ? $isFullyPaid = '1' : $isFullyPaid = '0';
		$data = array('userId'=>$this->input->post('fuserId'),
                	'isFullyPaid'=>$isFullyPaid,
					'date'=> date('Y/m/d',mktime(0,0,0,date("m"),date("d"),date("Y"))) , //Mark can you please edit this one to recod the correct date to the database
					);
		$this->db->insert('SalesTransaction',$data);
		$query = $this->db->query('SELECT SalesTransactionId FROM SalesTransaction ORDER BY SalesTransactionId DESC LIMIT 1');
		foreach ($query->result() as $row){
		   	$this->sales_model->insert($row->SalesTransactionId);
		}
	}
}