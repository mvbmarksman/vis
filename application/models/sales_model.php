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

	public function general(){
		$data['fuserId'] = array('name' => 'fuserId', 'label' => 'fuserId',);
		$data['fitemDetailId'] = array('name' => 'fitemDetailId', 'label' => 'fitemDetailId',);
		$data['funitPrice'] = array('name' => 'funitPrice', 'label' => 'funitPrice',);
		$data['fqty'] = array('name' => 'fqty', 'label' => 'fqty',);
		$data['fdiscount'] = array('name' => 'fdiscount', 'label' => 'fdiscount',);
		$data['fstoreId'] = array('name' => 'fstoreId', 'label' => 'fstoreId',);
		$data['fisVAT'] = array('name' => 'fisVAT', 'label' => 'fisVAT',);
		$data['fisFullyPaid'] = array('name' => 'fisFullyPaid', 'label' => 'fisFullyPaid',);

		return $data;


	}

	public function insert($salesTransactionId){

		$this->input->post('fisVAT') == 'on' ? $isVAT = '1' : $isVAT = '0';
		$data = array('salesTransactionId' => $salesTransactionId,
					'itemDetailId'=>$this->input->post('fitemDetailId'),
	                'unitPrice'=>$this->input->post('funitPrice'),
        	        'qty'=>$this->input->post('fqty'),
                	'discount'=>$this->input->post('fdiscount'),
                	'storeId'=>$this->input->post('fstoreId'),
                	'isVAT'=>$isVAT,
					);
		$this->db->insert('Sales',$data);
	}
}