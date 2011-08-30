<?php
class Admin_store extends MY_Controller
{
	public $libs = array('view');

	public $services = array(
		'store',
	);


	public function performsaveorupdate()
	{
		$data = $this->input->post();
		$storeService = new StoreService();
		$storeId = $storeService->saveOrUpdate($data);
		$this->load->helper('url');
		redirect('admin_store');
	}


	public function index()
	{
		$this->view->addCss('admin.css');
		$this->renderView('index', array());
	}


	/**
	 * Gets the data needed by the flexigrid for store
	 * Ajax call
	 * @return JSON
	 */
	public function getgriddata()
	{
		$data = $this->input->post();
		$storeService = new StoreService();
		$criteria = new CriteriaVO();
		$criteria->pageNo = $data['page'];
		$criteria->recordsPerPage = $data['rp'];
		$criteria->sortName = $data['sortname'];
		$criteria->sortOrder = $data['sortorder'];
		$criteria->searchField = $data['qtype'];
		$criteria->searchKey = empty($data['query']) ? null : $data['query'];
		$items = $storeService->fetchCriteriaBased($criteria);
		$itemsCount = $storeService->fetchCountCriteriaBased($criteria);

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
			$items[$key]['check'] = "<input type='checkbox' name='storeCheckbox' value='{$item['storeId']}' />";
			$viewLink = "/admin_store/view/id/{$item['storeId']}";
			$editLink = "/admin_store/edit/id/{$item['storeId']}";
			$items[$key]['actions'] = "<a href='{$viewLink}'><img src='".VIEW_IMG_URI."' /></a>"
				. "&nbsp; <a href='{$editLink}'><img src='".EDIT_IMG_URI."' /></a>";
		}
		return $items;
	}


	/**
	 * Gets the data for a specific store
	 * Ajax call
	 * @return JSON
	 */
	public function getstoredata()
	{
		$storeId = $this->input->post('storeId');
		$storeService = new StoreService();
		$storeData = $storeService->fetchById($storeId);
		echo json_encode($storeData);
	}


	public function delete()
	{
		$storeIds = $this->input->post('storeIds');
		$storeService = new StoreService();
		$storeService->delete($storeIds);
	}

}