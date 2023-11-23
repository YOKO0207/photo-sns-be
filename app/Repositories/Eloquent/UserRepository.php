<?php

namespace App\Repositories\Eloquent;

use App\Exceptions\{
	UpdateFailedException,
	DeleteFailedException,
};
use App\Models\User;
use App\Repositories\Contracts\UserRepositoryInterface;

class UserRepository implements UserRepositoryInterface
{

	protected $model;

	/**
	 * Create a new repository instance.
	 *
	 * @param User $model
	 */

	public function __construct(User $model)
	{
		$this->model = $model;
	}

	/**
	 * Create a record.
	 * 
	 * @param array $data
	 * @return User
	 */
	public function create(array $data): User
	{
		return $this->model->create($data);
	}

	/**
	 * Find a record.
	 * 
	 * @param string $id
	 * @return User
	 */
	public function findById(string $id): User
	{
		return User::where('id', '=', $id)->firstOrFail();
	}

	/**
	 * Find a record by email.
	 * 
	 * @param string $email
	 * @return User
	 */
	public function findByEmail(string $email): User
	{
		return $this->model->where('email', $email)->first();
	}

	/**
	 * Update a record.
	 * 
	 * @param array $data
	 * @param string $id
	 * @return User
	 */
	public function update(array $data, string $id): User
	{
		$model = $this->findById($id);

		if (!$model->update($data)) {
			throw new UpdateFailedException("UpdateFailedException in UserRepository@update");
		}
		return $model->fresh();
	}

	/**
	 * Update a record.
	 * 
	 * @param array $data
	 * @param string $id
	 * @return User
	 */
	public function updatePassword(array $data, string $id): User
	{
		$model = $this->findById($id);

		if (!$model->update($data)) {
			throw new UpdateFailedException("UpdateFailedException in UserRepository@updatePassword");
		}
		return $model->fresh();
	}

	/**
	 * Delete a record.
	 * 
	 * @param string $id
	 * @return bool
	 */
	public function delete(string $id): bool
	{
		if (!$this->findById($id)->delete()) {
			throw new DeleteFailedException("DeleteFailedException in UserRepository@delete");
		}
		return true;
	}

	/**
	 * Check if email exists.
	 * 
	 * @param string $id
	 * @return bool
	 */
	public function checkIfIdExists(string $id): bool
	{
		return $this->model->where('id', $id)->exists();
	}

	/**
	 * Check if email exists.
	 * 
	 * @param string $email
	 * @return bool
	 */
	public function checkIfEmailExists(string $email): bool
	{
		return $this->model->where('email', $email)->exists();
	}
}
