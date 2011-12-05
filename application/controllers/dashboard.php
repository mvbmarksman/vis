<?php

class Dashboard extends MY_Controller
{

    public $services = array(
        'stock',
        'sales_transaction',
        'item_expense',
        'other_expense',
        'credit',
    );


    public function index()
    {
        $this->view->addCss('dashboard/index.css');

        $stockService = new StockService();
        $itemsLowInStock = $stockService->fetchLowInStock();

        $currentDate = date('Y-m-d');
        $totalExpenses = $this->_getTotalExpense($currentDate);
        $totalSales = 0;
        $overdueCredits = array();

        $salesTransactionService = new SalesTransactionService();
        $totalSales = $salesTransactionService->fetchTotalSales($currentDate);

        $creditService = new CreditService();
        $overdueCredits = $creditService->fetchOverdueCredits();

        $this->renderView('index', array(
            'itemsLowInStock' => $itemsLowInStock,
            'totalExpenses' => $totalExpenses,
            'totalSales' => $totalSales,
            'overdueCredits' => $overdueCredits,
        ));
    }


    private function _getTotalExpense($currentDate)
    {
        $itemExpenseService = new ItemExpenseService();
        $totalItemExpense = $itemExpenseService->getTotalExpense($currentDate);

        $otherExpenseService = new OtherExpenseService();
        $totalOtherExpense = $otherExpenseService->getTotalExpense($currentDate);

        return $totalItemExpense + $totalOtherExpense;
    }

}