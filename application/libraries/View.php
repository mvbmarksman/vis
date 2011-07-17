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


	public function addJs($jsFile) {
		$jsFiles = $this->fetch('jsFiles');
		if (empty($jsFiles)) {
			$jsFiles = array();
		}

		if (is_array($jsFile)) {
			$jsFiles = array_merge($jsFiles, $jsFile);
		} else {
			$jsFiles[] = $jsFile;
		}

		$this->set('jsFiles', $jsFiles);
	}
}