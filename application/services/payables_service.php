<?php
class PayablesService extends MY_Service
{
        const FILTER_ACTIVE = 'active';
        const FILTER_PAID = 'paid';
        const FILTER_OVERDUE = 'overdue';


        public function fetchPayablesList($showFilter = self::FILTER_ACTIVE, $fromDate = null, $toDate = null, $supplierId = null)
	{
		$this->db->select('*')
			->from('ItemExpense ie')
			->join('Supplier s', 'ie.supplierId=s.supplierId', 'left')
                        ->join('Item i', 'i.itemId = ie.itemId')
                        ->where('ie.isCredit = 1');

                switch ($showFilter) {
                    case self::FILTER_PAID:
                        $this->db->where('ie.isFullyPaid = 1');
                        break;
                    case self::FILTER_OVERDUE:
                        $this->db->where('CURDATE() > ie.dueDate');
                    default:
                        $this->db->where('ie.isFullyPaid = 0');
                        break;
                }

                if (!empty($fromDate) && !empty($toDate)) {
                    $this->db->where('DATE(ie.dateAdded) >= ', $fromDate);
                    $this->db->where('DATE(ie.dateAdded) <= ', $toDate);

                } elseif (!empty($fromDate) && empty($toDate)) {
                    $this->db->where('DATE(ie.dateAdded) >= ', $fromDate);
                    $this->db->where('DATE(ie.dateAdded) <= ', date('Y-m-d'));

                } elseif (empty($fromDate) && !empty($toDate)) {
                    $this->db->where('DATE(ie.dateAdded) <= ', $toDate);
                }

                if (!empty($supplierId)) {
                    $this->db->where('ie.supplierId', $supplierId);
                }

		$query = $this->db->get();
		Debug::log($this->db->last_query());
		return $query->result_array();
	}
}
