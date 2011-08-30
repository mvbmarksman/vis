<?php
class Admin_user extends MY_Controller
{
	public $services = array(
		'user',
	);


	public function performsaveorupdate()
	{
		$data = $this->input->post();
		$userService = new UserService();
		$userId = $userService->saveOrUpdate($data);
		$this->load->helper('url');
		redirect('admin_user');
	}


	public function index()
	{
		$this->view->addCss('admin.css');
		$this->renderView('index', array());
	}


	/**
	 * Gets the data needed by the flexigrid for user
	 * Ajax call
	 * @return JSON
	 */
	public function getgriddata()
	{
		$data = $this->input->post();
		$userService = new UserService();
		$criteria = new CriteriaVO();
		$criteria->pageNo = $data['page'];
		$criteria->recordsPerPage = $data['rp'];
		$criteria->sortName = $data['sortname'];
		$criteria->sortOrder = $data['sortorder'];
		$criteria->searchField = $data['qtype'];
		$criteria->searchKey = empty($data['query']) ? null : $data['query'];
		$items = $userService->fetchCriteriaBased($criteria);
		$itemsCount = $userService->fetchCountCriteriaBased($criteria);

		foreach ($items as $key => $item) {
			$items[$key]['check'] = "<input type='checkbox' name='userCheckbox' value='{$item['userId']}' />";
		}

		$this->load->library('flexigrid');
		Flexigrid::create($items, $criteria->pageNo, $itemsCount);
	}


	/**
	 * Gets the data for a specific user
	 * Ajax call
	 * @return JSON
	 */
	public function getuserdata()
	{
		$userId = $this->input->post('userId');
		$userService = new UserService();
		$userData = $userService->fetchById($userId);
		echo json_encode($userData);
	}


	public function delete()
	{
		$userIds = $this->input->post('userIds');
		$userService = new UserService();
		$userService->delete($userIds);
	}

}