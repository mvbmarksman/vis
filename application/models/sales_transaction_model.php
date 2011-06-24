<?php
class Sales_transaction_model extends CI_Model
{
	public $salesTransactionId;
	public $date;
	public $userId;
	public $creditId;
	public $totalPrice;
	public $isFullyPaid;

	private $_name = 'Sales_transaction_model';

	public function __construct()
	{
		$this->load->database();
		parent::__construct();
	}

	public function insert($creditId){
		$this->load->model('sales_model');

		$this->input->post('fisFullyPaid') == 'on' ? $isFullyPaid = '1' : $isFullyPaid = '0';
		$data = array('userId'=>$this->input->post('fuserId'),
                	'isFullyPaid'=>$isFullyPaid,
					'creditId'=>$creditId,
					'date'=> date('Y/m/d',mktime(0,0,0,date("m"),date("d"),date("Y"))) , //Mark can you please edit this one to recod the correct date to the database
					);
		$this->db->insert('SalesTransaction',$data);

		//trying to get the latest sales transation ID to attach it the sales table
		$query = $this->db->query('SELECT SalesTransactionId FROM SalesTransaction ORDER BY SalesTransactionId DESC LIMIT 1');
		foreach ($query->result() as $row){
		   	$this->sales_model->insert($row->SalesTransactionId);
		}
	}
}