<?php
class CategoryService extends MY_Service
{
	public $models = array(
		'category',
	);

	public function fetchAll()
	{
		$category = new Category_model();
		$results = $category->fetchAll();
		return $results;
	}

//	public function saveOrUpdate($data)
//	{
//		if (empty($data)) {
//			throw new InvalidArgumentException('Data cannot be empty.');
//		}
//		$category = new Item_type_model();
//		$category->name = $data['name'];
//		if (!empty($data['categoryId'])) {
//			$category->categoryId = $data['categoryId'];
//			$categoryId = $category->update();
//			return $categoryId;
//		}
//		$categoryId = $category->insert();
//		return $categoryId;
//	}
//
//	public function fetchCriteriaBased($criteria)
//	{
//		$category = new Item_type_model();
//		$categorys = $category->fetchCriteriaBased($criteria);
//		return $categorys;
//	}
//
//	public function fetchCountCriteriaBased($criteria)
//	{
//		$category = new Item_type_model();
//		$count = $category->fetchCountCriteriaBased($criteria);
//		return $count;
//	}
//
//	public function fetchById($categoryId)
//	{
//		$category = new Item_type_model();
//		$categoryData = $category->fetchById($categoryId);
//		return $categoryData;
//	}
//
//
//	public function delete($categoryIds)
//	{
//		$category = new Item_type_model();
//		$category->delete($categoryIds);
//	}

}