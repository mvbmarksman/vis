<?php
class CriteriaVO
{
	public $pageNo;

	public $recordsPerPage;

	public $sortName;

	public $sortOrder;

	public $searchField;

	public $searchKey;

	public function getOffset()
	{
		return $this->recordsPerPage * ($this->pageNo - 1);
	}

}