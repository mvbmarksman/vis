<?php
/*
 * http://codeigniter.com/forums/viewthread/84781/
 */
class MY_Controller extends CI_Controller {

	private $_controllerName;
	private $_model;

	public $models;
	public $libs;

	public function __construct() {
		parent::__construct();
		$this->_controllerName = strtolower(get_class($this));
		foreach ($this->models as $model) {
			$this->load->model($model);
		}
		foreach ($this->libs as $lib) {
			$this->load->library($lib);
		}
	}


	public function setModel($model) {
		$this->_model = $model;
	}


	/**
	 * Encapsulates rendering of view
	 * @param String $template - refers to the name of the template file
	 * @param mixed $data - what you want to set in the view
	 */
	public function renderView($template, $data) {
		$this->load->library('view');
		$this->view->layout = 'layout';
		$this->view->load('menu', 'common/menu', array());
		$this->view->load('search', 'common/search', array());
		$this->view->load('content', $this->_controllerName . '/' . $template, $data);
		$this->view->render();

	}

	public function listall() {
		$this->renderView('listall', array());
	}

	public function getgriddata() {
		$model = $this->_model;
		$this->load->model($model);
		$items = $this->$model->fetch();
		if (!$items) {
			return;
		}
		$this->load->library('flexigrid');
		Flexigrid::create($items);
	}

}