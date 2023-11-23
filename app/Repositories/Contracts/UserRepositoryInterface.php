<?php

namespace App\Repositories\Contracts;

use App\Models\User;

interface UserRepositoryInterface
{
	/**
	 * Create a record.
	 * 
	 * @param array $data
	 * @return User
	 */
	public function create(array $data): User;

	/**
	 * Find a record.
	 * 
	 * @param string $id
	 * @return User
	 */
	public function findById(string $id): User;

	/**
	 * Find a record by email.
	 * 
	 * @param string $email
	 * @return User
	 */
	public function findByEmail(string $email): User;

	/**
	 * Update a record.
	 * 
	 * @param array $data
	 * @param string $id
	 * @return User
	 */
	public function update(array $data, string $id): User;

	/**
	 * Update a record.
	 * 
	 * @param array $data
	 * @param string $id
	 * @return User
	 */
	public function updatePassword(array $data, string $id): User;

	/**
	 * Delete a record.
	 * 
	 * @param string $id
	 * @return bool
	 */
	public function delete(string $id): bool;

	/**
	 * Check if email exists.
	 * 
	 * @param string $id
	 * @return bool
	 */
	public function checkIfIdExists(string $id): bool;

	/**
	 * Check if email exists.
	 * 
	 * @param string $email
	 * @return bool
	 */
	public function checkIfEmailExists(string $email): bool;
}
