<?php

namespace App\Repositories\Contracts;

use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

interface ScopedListableCrudRepositoryInterface
{
	/**
	 * Find all records searched and paginated.
	 * 
	 * @param int $pagination
	 * @param string $id
	 * @return LengthAwarePaginator
	 */
	public function findAllPaginated(int $pagination, string $id): LengthAwarePaginator;

	/**
	 * Find all records.
	 * 
	 * @param string $id
	 * @return Collection|Model[]
	 */
	public function findAll(string $id): Collection;
	
	/**
	 * Create a record.
	 * 
	 * @param array $data
	 * @return Model
	 */
	public function create(array $data): Model;

	/**
	 * Find a record.
	 * 
	 * @param string $id
	 * @return Model
	 */
	public function findById(string $id): Model;

	/**
	 * Update a record.
	 * 
	 * @param array $data
	 * @param string $id
	 * @return Model
	 */
	public function update(array $data, string $id): Model;

	/**
	 * Delete a record.
	 * 
	 * @param string $id
	 * @return bool
	 */
	public function delete(string $id): bool;
}
