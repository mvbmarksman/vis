<?php
class UserService extends MY_Service
{
	public $models = array(
		'user',
	);

	public function fetchAllItems()
	{
		$user = new User_model();
		$results = $user->fetchAll();
		return $results;
	}

	public function saveOrUpdate($data)
	{
		if (empty($data)) {
			throw new InvalidArgumentException('Data cannot be empty.');
		}
		$user = new User_model();
		$user->username = $data['username'];
		$user->password = $data['password'];
		$user->firstName = $data['firstName'];
		$user->lastName = $data['lastName'];
		$user->isAdmin = $data['isAdmin'];

		if (!empty($data['userId'])) {
			$user->userId = $data['userId'];
			$userId = $user->update();
			return $userId;
		}
		$userId = $user->insert();
		return $userId;
	}

	public function fetchCriteriaBased($criteria)
	{
		$user = new User_model();
		$users = $user->fetchCriteriaBased($criteria);
		return $users;
	}

	public function fetchCountCriteriaBased($criteria)
	{
		$user = new User_model();
		$count = $user->fetchCountCriteriaBased($criteria);
		return $count;
	}

	public function fetchById($userId)
	{
		$user = new User_model();
		$userData = $user->fetchById($userId);
		return $userData;
	}


	public function delete($userIds)
	{
		$user = new User_model();
		$user->delete($userIds);
	}

}