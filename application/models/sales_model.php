<?php
class Sales_model extends CI_Model
{
	public $salesId;
  	public $salesTransactionId;
  	public $itemDetailId;
  	public $unitPrice;
  	public $qty;
  	public $discount;
  	public $storeId;
  	public $isVAT;

	private $_name = 'Sales';

	public function __construct()
	{
		$this->load->database();
		parent::__construct();
	}

	public function insert(){
		$data = array('salesTransactionId' => '1',
					'itemDetailId'=>$this->input->post('fitemDetailId'),
	                'unitPrice'=>$this->input->post('funitPrice'),
        	        'qty'=>$this->input->post('fqty'),
                	'discount'=>$this->input->post('fdiscount'),
                	'storeId'=>$this->input->post('fstoreId'),
                	);
		$this->db->insert('Sales',$data);
	}
}