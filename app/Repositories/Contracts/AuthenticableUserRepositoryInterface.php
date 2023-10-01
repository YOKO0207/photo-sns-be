<?php

namespace App\Repositories\Contracts;

use App\Models\Contracts\AuthenticableUser;

interface AuthenticableUserRepositoryInterface
{
	/**
	 * Create a record.
	 * 
	 * @param array $data
	 * @return AuthenticableUser
	 */
	public function create(array $data): AuthenticableUser;

	/**
	 * Find a record.
	 * 
	 * @param string $id
	 * @return AuthenticableUser
	 */
	public function findById(string $id): AuthenticableUser;

	/**
	 * Find a record by email.
	 * 
	 * @param string $email
	 * @return AuthenticableUser
	 */
	public function findByEmail(string $email): AuthenticableUser;

	/**
	 * Update a record.
	 * 
	 * @param array $data
	 * @param string $id
	 * @return AuthenticableUser
	 */
	public function update(array $data, string $id): AuthenticableUser;

	/**
	 * Update a record.
	 * 
	 * @param array $data
	 * @param string $id
	 * @return AuthenticableUser
	 */
	public function updatePassword(array $data, string $id): AuthenticableUser;

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
