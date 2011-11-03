<?php
class SalesService extends MY_Service
{

	public $models = array(
		'sales',
		'sales_transaction'
	);

	public $services = array(
		'sales_transaction',
		'customer',
		'stock',
	);


	public function processSalesForm($data)
	{
		$this->db->trans_begin();
		$salesTransactionId = null;
		try {
			Debug::log($data);
			$customerService = new CustomerService();
			$customerId = $customerService->saveOrUpdate($data);
			$data['customerId'] = $customerId;

			$salesTransactionService = new SalesTransactionService();
			$salesTransactionId = $salesTransactionService->insert($data);
			$data['salesTransactionId'] = $salesTransactionId;

			$salesObjs = $this->marshallSales($data);
			$salesObjs = $this->mergeSimilarItems($salesObjs);
			$totals = $this->saveAndComputeTotal($salesObjs);
			$data['totalPrice'] = $totals['totalPrice'];
			$data['totalVatable'] = $totals['totalVatable'];
			$data['totalVat'] = $totals['totalVat'];

			Debug::log('removing items from the stocks');
			$this->removeItemsFromStocks($salesObjs);
			Debug::log('updating sales transaction data');
			$salesTransactionService->update($data);
		} catch (Exception $e) {
			$this->db->trans_rollback();
			throw new Exception($e->getMessage());
		}
		Debug::log('committing transaction');
		$this->db->trans_commit();
		return $salesTransactionId;
	}


	/**
	 * Instantiates sales objects from the data
	 *
	 * @param mixed $data
	 */
	public function marshallSales($data)
	{
		if (!empty($data['vat'])) {
			foreach ($data['vat'] as $vatId){
				$isVAT[substr($vatId, 4)] = true;
			}
		}
		$salesObjs = array();
		// we start from 1 to remove data coming from template
		for ($i = 1; $i < count($data['item']); $i++) {
			$sales = new Sales_model();
			$sales->salesTransactionId = $data['salesTransactionId'];
			$sales->itemId = $data['item'][$i];
			$sales->sellingPrice = $data['price'][$i];
			$sales->discount = $data['discount'][$i];
			$sales->storeId = 1; // TODO stub data;
			$sales->qty = $data['qty'][$i];
			$sales->subTotal = $sales->sellingPrice * $sales->qty - $sales->discount;
			if (!empty($isVAT[$i])) {
				$sales->vatable = $sales->subTotal / 1.12;
				$sales->vat = $sales->vatable * 0.12;
			}
			$salesObjs[] = $sales;
		}
		return $salesObjs;
	}


	/**
	 * If the sales objects are the same, merge them together
	 * by adding together the quantities.
	 *
	 * @param mixed $salesObjs
	 */
	public function mergeSimilarItems($salesObjs)
	{
		if (empty($salesObjs)) {
			return array();
		}

		Debug::log('Sales Objects before merge:');
		foreach ($salesObjs as $s) {
			Debug::log($s);
		}

		for ($i = 0; $i < count($salesObjs); $i++) {
			for ($j = 1; $j < count($salesObjs); $j++) {
				if ($i == $j || $salesObjs[$i] == null || $salesObjs[$j] == null) {
					continue;
				}
				if ($salesObjs[$i]->itemId == $salesObjs[$j]->itemId
					&& empty($salesObjs[$i]->vatable) == empty($salesObjs[$j]->vatable)
					&& $salesObjs[$i]->sellingPrice == $salesObjs[$j]->sellingPrice) {
					$salesObjs[$i]->qty += $salesObjs[$j]->qty;
					$salesObjs[$i]->discount += $salesObjs[$j]->discount;
					$salesObjs[$i]->subTotal = $salesObjs[$i]->sellingPrice * $salesObjs[$i]->qty - $salesObjs[$i]->discount;
					if (!empty($salesObjs[$i]->vatable)) {
						$salesObjs[$i]->vatable = $salesObjs[$i]->subTotal / 1.12;
						$salesObjs[$i]->vat = $salesObjs[$i]->vatable * 0.12;
					}
					$salesObjs[$j] = null;
				}
			}
		}

		Debug::log('Sales Objects after merge:');
		$newObjsList = array();
		foreach ($salesObjs as $s) {
			if ($s == null) {
				continue;
			}
			$newObjsList[] = $s;
			Debug::log($s);
		}
		return $newObjsList;
	}


	public function saveAndComputeTotal($salesObjs)
	{
		$totalPrice = 0;
		$totalVatable = 0;
		$totalVat = 0;
		foreach ($salesObjs as $sales) {
			Debug::log($sales);
			$sales->insert();
			$totalPrice += $sales->subTotal;
			$totalVatable += $sales->vatable;
			$totalVat += $sales->vat;
		}
		Debug::log("totalPrice: $totalPrice");
		Debug::log("totalVatable: $totalVatable");
		Debug::log("totalVat: $totalVat");

		return array(
			'totalPrice' 	=> $totalPrice,
			'totalVatable'	=> $totalVatable,
			'totalVat'		=> $totalVat,
		);
	}

	public function removeItemsFromStocks($salesObjs)
	{
		$stockService = new StockService();
		foreach ($salesObjs as $salesObj) {
			// TODO hardcoded
			$stockService->removeItemsFromStore($salesObj->itemId, 1, $salesObj->qty);
		}
	}
}