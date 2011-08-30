<?php
class Admin_item_type extends MY_Controller
{
	public $services = array(
		'item_type',
	);


	public function performsaveorupdate()
	{
		$data = $this->input->post();
		$itemTypeService = new ItemTypeService();
		$itemTypeId = $itemTypeService->saveOrUpdate($data);
		$this->load->helper('url');
		redirect('admin_item_type');
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
		$itemTypeService = new ItemTypeService();
		$criteria = new CriteriaVO();
		$criteria->pageNo = $data['page'];
		$criteria->recordsPerPage = $data['rp'];
		$criteria->sortName = $data['sortname'];
		$criteria->sortOrder = $data['sortorder'];
		$criteria->searchField = $data['qtype'];
		$criteria->searchKey = empty($data['query']) ? null : $data['query'];
		$items = $itemTypeService->fetchCriteriaBased($criteria);
		$itemsCount = $itemTypeService->fetchCountCriteriaBased($criteria);

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
			$items[$key]['check'] = "<input type='checkbox' name='itemTypeCheckbox' value='{$item['itemTypeId']}' />";
			$viewLink = "/admin_item_type/view/id/{$item['itemTypeId']}";
			$editLink = "/admin_item_type/edit/id/{$item['itemTypeId']}";
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
		$itemTypeId = $this->input->post('itemTypeId');
		$itemTypeService = new ItemTypeService();
		$itemTypeData = $itemTypeService->fetchById($itemTypeId);
		echo json_encode($itemTypeData);
	}


	public function delete()
	{
		$itemTypeIds = $this->input->post('itemTypeIds');
		$itemTypeService = new ItemTypeService();
		$itemTypeService->delete($itemTypeIds);
	}

}