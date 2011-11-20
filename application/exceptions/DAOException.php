<?php
class DAOException extends Exception {

	public function __construct($message, $code = null) {
		parent::__construct($message, $code);
	}
}