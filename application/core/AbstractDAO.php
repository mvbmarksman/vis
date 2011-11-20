<?php
interface AbstractDAO
{
	private function _checkArgs();

	public function insert();

	public function fetchByCriteria();

	public function update();

}