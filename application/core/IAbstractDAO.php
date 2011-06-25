<?php
interface IAbstractDAO
{
	public function save($object);

	public function fetch($id = null);

	public function delete($id);
}