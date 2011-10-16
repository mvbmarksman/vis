<?php
class EmptyResultSetException extends Exception {

	public function __construct($message, $code = null) {
		parent::__construct($message, $code);
	}
}