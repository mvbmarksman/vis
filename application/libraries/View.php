<?php
require_once APPPATH . 'libraries/BaseView.php';
class View extends BaseView {


	public function addCss($cssFile) {
		$cssFiles = $this->fetch('cssFiles');
		if (empty($cssFiles)) {
			$cssFiles = array();
		}

		if (is_array($cssFile)) {
			$cssFiles = array_merge($cssFiles, $cssFile);
		} else {
			$cssFiles[] = $cssFile;
		}

		$this->set('cssFiles', $cssFiles);
	}
}