<?php
class CustomLoader
{
	public function __construct()
	{
		require APPPATH . 'vo/CriteriaVO.php';
		require APPPATH . 'exceptions/EmptyResultSetException.php';
	}
}