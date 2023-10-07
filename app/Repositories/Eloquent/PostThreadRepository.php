<?php

namespace App\Repositories\Eloquent;

use App\Exceptions\{
	UpdateFailedException,
	DeleteFailedException
};
use Illuminate\Pagination\LengthAwarePaginator;
use App\Models\PostThread;
use App\Queries\Contracts\ScopedListQueryInterface;
use App\Repositories\Contracts\ScopedListableCrudRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

class PostThreadRepository implements ScopedListableCrudRepositoryInterface
{

	protected $model;
	protected $query;

	/**
	 * Create a new repository instance.
	 *
	 * @param PostThread $model
	 * @param ListQueryInterface $query
	 */

	public function __construct(PostThread $model, ScopedListQueryInterface $query)
	{
		$this->model = $model;
		$this->query = $query;
	}

	/**
	 * Find all records searched and paginated.
	 * 
	 * @param int $pagination
	 * @param string $postId
	 * @return LengthAwarePaginator;
	 */
	public function findAllPaginated(int $pagination, string $postId): LengthAwarePaginator
	{
		return $this->query->searchAll($postId)->paginate($pagination);
	}

	/**
	 * Find all records.
	 * 
	 * @param string $postId
	 * @return Collection
	 */
	public function findAll(string $postId): Collection
	{
		return $this->query->searchAll($postId)->get();
	}

	/**
	 * Create a record.
	 * 
	 * @param array $data
	 * @return PostThread
	 */
	public function create(array $data): PostThread
	{
		return $this->model->create($data);
	}

	/**
	 * Find a record.
	 * 
	 * @param string $id
	 * @return PostThread
	 */
	public function findById(string $id): PostThread
	{
		return PostThread::where('id', '=', $id)->firstOrFail();
	}

	/**
	 * Update a record.
	 * 
	 * @param array $data
	 * @param string $id
	 * @return PostThread
	 */
	public function update(array $data, string $id): PostThread
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
