<?php
/*
 * http://codeigniter.com/forums/viewthread/84781/
 */
class MY_Controller extends CI_Controller {

	public function __construct($isAdmin = false) {
		parent::__construct();
		$this->load->library('view');

		$this->view->layout = $isAdmin ? 'admin_layout' : 'layout';
		$this->view->load('menu', 'common/menu', array());
	}

}