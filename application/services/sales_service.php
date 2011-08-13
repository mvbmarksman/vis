<?php
class SalesService extends MY_Service
{

	public $models = array(
		'sales',
	);


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
			$sales->itemDetailId = $data['item'][$i];
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

		for ($i = 0; $i < count($salesObjs); $i++) {
			for ($j = 1; $j < count($salesObjs); $j++) {
				if ($i == $j) {
					continue;
				}
				if ($salesObjs[$i]->itemDetailId == $salesObjs[$j]->itemDetailId
					&& $salesObjs[$i]->isVAT == $salesObjs[$j]->isVAT
					&& $salesObjs[$i]->discount == $salesObjs[$j]->discount
					&& $salesObjs[$i]->sellingPrice == $salesObjs[$j]->sellingPrice) {
					$salesObjs[$i]->qty += $salesObjs[$j]->qty;
					unset($salesObjs[$j]);
				}
			}
		}
		return $salesObjs;
	}


	public function saveAndComputeTotal($salesObjs)
	{
		Debug::log('SalesService::saveAndCompute');
		$totalPrice = 0;
		$totalVatable = 0;
		$totalVat = 0;
		foreach ($salesObjs as $sales) {
			Debug::log($sales->__toString());
			$sales->insert();
			$totalPrice += $sales->sellingPrice;
			$totalVatable += $sales->vatable;
			$totalVat += $sales->vat;
		}
		return array(
			'totalPrice' 	=> $totalPrice,
			'totalVatable'	=> $totalVatable,
			'totalVat'		=> $totalVat,
		);
	}
}