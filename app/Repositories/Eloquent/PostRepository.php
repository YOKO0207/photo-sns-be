<?php

namespace App\Repositories\Eloquent;

use App\Exceptions\{
	UpdateFailedException,
	DeleteFailedException
};
use Illuminate\Pagination\LengthAwarePaginator;
use App\Models\Post;
use App\Queries\Contracts\ListQueryInterface;
use App\Repositories\Contracts\ListableCrudRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

class PostRepository implements ListableCrudRepositoryInterface
{

	protected $model;
	protected $query;

	/**
	 * Create a new repository instance.
	 *
	 * @param Post $model
	 * @param ListQueryInterface $query
	 */

	public function __construct(Post $model, ListQueryInterface $query)
	{
		$this->model = $model;
		$this->query = $query;
	}

	/**
	 * Find all records searched and paginated.
	 * 
	 * @param int $pagination
	 * @return LengthAwarePaginator;
	 */
	public function findAllPaginated(int $pagination): LengthAwarePaginator
	{
		return $this->query->searchAll()->paginate($pagination);
	}

	/**
	 * Find all records.
	 * 
	 * @param void
	 * @return Collection
	 */
	public function findAll(): Collection
	{
		return $this->query->searchAll()->get();
	}

	/**
	 * Create a record.
	 * 
	 * @param array $data
	 * @return Post
	 */
	public function create(array $data): Post
	{
		return $this->model->create($data);
	}

	/**
	 * Find a record.
	 * 
	 * @param string $id
	 * @return Post
	 */
	public function findById(string $id): Post
	{
		return Post::where('id', '=', $id)->firstOrFail();
	}

	/**
	 * Update a record.
	 * 
	 * @param array $data
	 * @param string $id
	 * @return Post
	 */
	public function update(array $data, string $id): Post
	{
		$model = $this->findById($id);

		if (!$model->update($data)) {
			throw new UpdateFailedException("UpdateFailedException in PostRepository@update");
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
			throw new DeleteFailedException("DeleteFailedException in PostRepository@delete");
		}
		return true;
	}
}
