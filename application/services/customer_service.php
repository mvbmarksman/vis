<?php
class CustomerService extends MY_Service
{
	public $models = array(
		'customer',
	);


	public function fetchAllItems()
	{
		$customer = new Customer_model();
		$results = $customer->fetchAll();
		return $results;
	}


	public function fetchCustomersWithCredit()
	{
		$customer = new Customer_model();
		$customers = $customer->fetchCustomersWithCredit();
		return $customers;
	}


	public function fetchByCriteria($criteria)
	{
		$customer = new Customer_model();
		return $customer->fetchByCriteria($criteria);
	}


	public function saveOrUpdate($data)
	{
		if (empty($data)) {
			throw new InvalidArgumentException('Data cannot be empty.');
		}
		$customer = new Customer_model();
		$customer->fullname = $data['name'];
		$customer->address = $data['address'];
		$customer->phoneNo = $data['contact'];
		if (!empty($data['customerId'])) {
			$customer->customerId = $data['customerId'];
			$customerId = $customer->update();
			return $customerId;
		}
		$customerId = $customer->insert();
		return $customerId;
	}


	public function delete($customerIds)
	{
		$customer = new Customer_model();
		$customer->delete($customerIds);
	}

}