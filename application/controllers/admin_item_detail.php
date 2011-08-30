<?php
class Admin_item_detail extends MY_Controller
{
	public $services = array(
		'item_detail',
	);


	public function performsaveorupdate()
	{
		$data = $this->input->post();
		$itemDetailService = new ItemDetailService();
		$itemDetailId = $itemDetailService->saveOrUpdate($data);
		$this->load->helper('url');
		redirect('itemDetail');
	}


	public function index()
	{
		$this->view->addCss('admin.css');
		$this->renderView('index', array());
	}


	/**
	 * Gets the data needed by the flexigrid for itemDetail
	 * Ajax call
	 * @return JSON
	 */
	public function getgriddata()
	{
		$data = $this->input->post();
		$itemDetailService = new ItemDetailService();
		$criteria = new CriteriaVO();
		$criteria->pageNo = $data['page'];
		$criteria->recordsPerPage = $data['rp'];
		$criteria->sortName = $data['sortname'];
		$criteria->sortOrder = $data['sortorder'];
		$criteria->searchField = $data['qtype'];
		$criteria->searchKey = empty($data['query']) ? null : $data['query'];
		$items = $itemDetailService->fetchCriteriaBased($criteria);
		$itemsCount = $itemDetailService->fetchCountCriteriaBased($criteria);

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
			$items[$key]['check'] = "<input type='checkbox' name='itemDetailCheckbox' value='{$item['itemDetailId']}' />";
			$viewLink = "/admin_item_detail/view/id/{$item['itemDetailId']}";
			$editLink = "/admin_item_detail/edit/id/{$item['itemDetailId']}";
			$items[$key]['actions'] = "<a href='{$viewLink}'><img src='".VIEW_IMG_URI."' /></a>"
				. "&nbsp; <a href='{$editLink}'><img src='".EDIT_IMG_URI."' /></a>";
		}
		return $items;
	}

	/**
	 * Gets the data for a specific itemDetail
	 * Ajax call
	 * @return JSON
	 */
	public function getitemDetaildata()
	{
		$itemDetailId = $this->input->post('itemDetailId');
		$itemDetailService = new ItemDetailService();
		$itemDetailData = $itemDetailService->fetchById($itemDetailId);
		echo json_encode($itemDetailData);
	}



	public function delete()
	{
		$itemDetailIds = $this->input->post('itemDetailIds');
		$itemDetailService = new ItemDetailService();
		$itemDetailService->delete($itemDetailIds);
	}

}