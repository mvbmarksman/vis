<?php
class Admin_customer extends MY_Controller
{
	public $services = array(
		'customer',
	);


	public function performsaveorupdate()
	{
		$data = $this->input->post();
		$customerService = new CustomerService();
		try {
			$customerId = $customerService->saveOrUpdate($data);
		} catch (Exception $e) {
			 header($_SERVER['SERVER_PROTOCOL'] . ' 500 Internal Server Error', true, 500);
			 return;
		}
		redirect('admin_customer');
	}


	public function index()
	{
		$this->view->addCss('admin.css');
		$this->view->addJs('admin.js');
		$this->renderView('index', array());
	}


	/**
	 * Gets the data needed by the flexigrid for customer
	 * Ajax call
	 * @return JSON
	 */
	public function getgriddata()
	{
		$data = $this->input->post();
		$customerService = new CustomerService();
		$criteria = new CriteriaVO();
		$criteria->pageNo = $data['page'];
		$criteria->recordsPerPage = $data['rp'];
		$criteria->sortName = $data['sortname'];
		$criteria->sortOrder = $data['sortorder'];
		$criteria->searchField = $data['qtype'];
		$criteria->searchKey = empty($data['query']) ? null : $data['query'];
		$items = $customerService->fetchCriteriaBased($criteria);
		$itemsCount = $customerService->fetchCountCriteriaBased($criteria);

		$items = $this->transformItems($items);

		$this->load->library('flexigrid');
		Flexigrid::create($items, $criteria->pageNo, $itemsCount);
	}


	/**
	 * Perform necessary transformations to the data.
	 */
	public function transformItems($items)
	{
		foreach ($items as $key => $item) {
			$items[$key]['check'] = "<input type='checkbox' name='customerCheckbox' value='{$item['customerId']}' />";
			$viewLink = 'javascript:view("' . $item['customerId'] . '")';
			$editLink = 'javascript:edit("' . $item['customerId'] . '")';
			$items[$key]['actions'] = "<a href='{$viewLink}'><img src='".VIEW_IMG_URI."' /></a>"
				. "&nbsp; <a href='{$editLink}'><img src='".EDIT_IMG_URI."' /></a>";
		}
		return $items;
	}


	/**
	 * Gets the data for a specific customer
	 * Ajax call
	 * @return JSON
	 */
	public function getcustomerdata()
	{
		$customerId = $this->input->post('customerId');
		$customerService = new CustomerService();
		$customerData = $customerService->fetchById($customerId);
		echo json_encode($customerData);
	}


	public function delete()
	{
		$customerIds = $this->input->post('customerIds');
		$customerService = new CustomerService();
		$customerService->delete($customerIds);
	}


	public function view()
	{
		$customerId = $this->input->post('customerId');
		if (empty($customerId)) {
			return;
		}
		$customerService = new CustomerService();
		$customerData = $customerService->fetchById($customerId);
		if (empty($customerData)) {
			return;
		}
		$this->renderAjaxView('view', array('customer' => $customerData));
	}


	public function add()
	{
		$this->renderAjaxView('add', array());
	}


	public function edit()
	{
		$customerId = $this->input->post('customerId');
		if (empty($customerId)) {
			return;
		}
		$customerService = new CustomerService();
		$customerData = $customerService->fetchById($customerId);
		if (empty($customerData)) {
			return;
		}
		$this->renderAjaxView('edit', array('customer' => $customerData));
	}

}
