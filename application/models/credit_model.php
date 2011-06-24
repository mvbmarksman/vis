<?php
class Credit_model extends CI_Model
{
	public $creditId;
	public $fullName;
	public $address;
	public $phoneNo;
	public $amountPaid;

	private $_name = 'Credit';

	public function __construct()
	{
		$this->load->database();
		parent::__construct();
	}

	public function insert(){
		$this->load->model('sales_transaction_model');
		$data = array('fullName'=>$this->input->post('ffullName'),
                	'address'=>$this->input->post('faddress'),
					'phoneNo'=> $this->input->post('fphoneNo') ,
					'amountPaid'=>$this->input->post('famountPaid'),
					);

		$this->db->insert('Credit',$data);
	//get the Credit ID to be attached to the Sales Transation
		$query = $this->db->query('SELECT CreditId FROM Credit ORDER BY CreditId DESC LIMIT 1');
		foreach ($query->result() as $row){
		   	$this->sales_transaction_model->insert($row->CreditId);
		}


	}
}