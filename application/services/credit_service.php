<?php

class CreditService extends MY_Service
{
    const FILTER_ACTIVE = 'active';
    const FILTER_PAID = 'paid';
    const FILTER_OVERDUE = 'overdue';

    public $models = array(
        'credit_payment',
        'sales_transaction',
    );


    public function fetchCreditList($showFilter = self::FILTER_ACTIVE, $fromDate = null, $toDate = null)
    {
        $this->db->select('st.*, c.*')
            ->from('SalesTransaction st')
            ->join('Customer c', 'c.customerId=st.customerId', 'left')
            ->where('isCredit = 1');

        switch ($showFilter) {
            case self::FILTER_PAID:
                $this->db->where('isFullyPaid = 1');
                break;
            case self::FILTER_OVERDUE:
                $this->db->where('CURDATE() > st.dueDate');
            default:
                $this->db->where('isFullyPaid = 0');
                break;
        }

        if (!empty($fromDate) && !empty($toDate)) {
            $this->db->where('DATE(st.transactionDate) >= ', $fromDate);
            $this->db->where('DATE(st.transactionDate) <= ', $toDate);
        } elseif (!empty($fromDate) && empty($toDate)) {
            $this->db->where('DATE(st.transactionDate) >= ', $fromDate);
            $this->db->where('DATE(st.transactionDate) <= ', date('Y-m-d'));
        } elseif (empty($fromDate) && !empty($toDate)) {
            $this->db->where('DATE(st.transactionDate) <= ', $toDate);
        }

        $query = $this->db->get();
        Debug::log($this->db->last_query());
        return $query->result_array();
    }


    public function fetchCreditsAndPaymentsForCustomer($customerId)
    {
        if (empty($customerId)) {
            return array();
        }

        $this->db->select('*')
            ->from('SalesTransaction st')
            ->where('st.isCredit = 1')
            ->where('st.customerId', (int) $customerId)
            ->order_by('isFullyPaid DESC, transactionDate');
        $query = $this->db->get();
        Debug::log($this->db->last_query());
        $results = $query->result_array();

        foreach ($results as $key => $result) {
            $results[$key]['creditPayments'] = $this->_fetchCreditPayments($result['salesTransactionId'], $customerId);
        }
        return $results;
    }


    public function _fetchCreditPayments($salesTransactionId, $customerId)
    {
        if (empty($salesTransactionId) || empty($customerId)) {
            return array();
        }
        $this->db->select('*')
            ->from('CreditPayment cp')
            ->where('salesTransactionId', (int) $salesTransactionId)
            ->where('customerId', (int) $customerId)
            ->order_by('datePaid');

        $query = $this->db->get();
        return $query->result_array();
    }


    public function addCreditPayment($data)
    {
        $this->db->trans_begin();
        try {
            $salesTransactionModel = new Sales_transaction_model();
            $salesTransaction = $salesTransactionModel->fetchById($data['salesTransactionId']);
            $updatedPaidAmount = (float) $data['amount'] + (float) $salesTransaction['totalAmountPaid'];

            if ($updatedPaidAmount > $salesTransaction['totalPrice']) {
                throw new Exception('Amount paid will exceed total transaction amount.');
            }

            $creditPaymentModel = new Credit_payment_model();
            $creditPaymentModel->customerId = $data['customerId'];
            $creditPaymentModel->salesTransactionId = $data['salesTransactionId'];
            $creditPaymentModel->amount = $data['amount'];
            $creditPaymentModel->insert();

            $updateData = array(
                'totalAmountPaid' => $updatedPaidAmount,
            );
            if ($updatedPaidAmount == $salesTransaction['totalPrice']) {
                $updateData['isFullyPaid'] = 1;
            }
            $this->db->where('salesTransactionId', $data['salesTransactionId']);
            $this->db->update('SalesTransaction', $updateData);
        } catch (Exception $e) {
            $this->db->trans_rollback();
            throw new Exception($e->getMessage());
        }
        $this->db->trans_commit();
    }


    public function fetchOverdueCredits()
    {
        $this->db->select('*')
            ->from('SalesTransaction st')
            ->where('st.isCredit', 1)
            ->where('st.isFullyPaid', 0)
            ->where('NOW() > st.dueDate');
        $query = $this->db->get();
        Debug::log($this->db->last_query());
        return $query->result_array();
    }

}
