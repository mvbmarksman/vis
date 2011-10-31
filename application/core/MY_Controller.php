<?php
require_once BASEPATH . 'core/Model.php';
require_once APPPATH . 'core/MY_Model.php';
require_once APPPATH . 'core/MY_Service.php';

class MY_Controller extends CI_Controller {

	public $libs = array();
	public $services = array();
	public $models = array();

	private $_controllerName;

	public function __construct() {
		parent::__construct();
		$this->_controllerName = strtolower(get_class($this));
		$this->_loadLibraries();
		$this->_loadServices();
		define('EDIT_IMG_URI', '/public/images/icons/edit.png');
		define('VIEW_IMG_URI', '/public/images/icons/magnifier.png');
	}


	private function _loadLibraries()
	{
		foreach ($this->libs as $lib) {
			$this->load->library($lib);
		}
	}


	private function _loadServices()
	{
		foreach ($this->services as $service) {
			require_once APPPATH . 'services/' . $service . '_service.php';
		}
	}


	private function _loadModels()
	{
		foreach ($this->models as $model) {
			require_once APPPATH . 'models/' . $model . '_model.php';
		}
	}


	/**
	 * Encapsulates rendering of view
	 * @param String $template - refers to the name of the template file
	 * @param mixed $data - what you want to set in the view
	 */
	public function renderView($template, $data) {
		$this->view->layout = 'layout';
		$this->view->load('menu', 'common/menu', array());
		$this->view->load('search', 'common/search', array());
		$this->view->load('content', $this->_controllerName . '/' . $template, $data);
		$this->view->render();

	}

	public function renderAjaxView($template, $data) {
		$content = $this->view->load('content', $this->_controllerName . '/' . $template, $data);
		$this->view->render();
	}
}