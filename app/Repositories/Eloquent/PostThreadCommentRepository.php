<?php

namespace App\Repositories\Eloquent;

use App\Exceptions\{
	UpdateFailedException,
	DeleteFailedException
};
use Illuminate\Pagination\LengthAwarePaginator;
use App\Models\PostThreadComment;
use App\Queries\Contracts\ScopedListQueryInterface;
use App\Repositories\Contracts\ScopedListableCrudRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

class PostThreadCommentRepository implements ScopedListableCrudRepositoryInterface
{

	protected $model;
	protected $query;

	/**
	 * Create a new repository instance.
	 *
	 * @param PostThreadComment $model
	 * @param ListQueryInterface $query
	 */

	public function __construct(PostThreadComment $model, ScopedListQueryInterface $query)
	{
		$this->model = $model;
		$this->query = $query;
	}

	/**
	 * Find all records searched and paginated.
	 * 
	 * @param int $pagination
	 * @param string $postThreadId
	 * @return LengthAwarePaginator;
	 */
	public function findAllPaginated(int $pagination, string $postThreadId): LengthAwarePaginator
	{
		return $this->query->searchAll($postThreadId)->paginate($pagination);
	}

	/**
	 * Find all records.
	 * 
	 * @param string $postThreadId
	 * @return Collection
	 */
	public function findAll(string $postThreadId): Collection
	{
		return $this->query->searchAll($postThreadId)->get();
	}

	/**
	 * Create a record.
	 * 
	 * @param array $data
	 * @return PostThreadComment
	 */
	public function create(array $data): PostThreadComment
	{
		return $this->model->create($data);
	}

	/**
	 * Find a record.
	 * 
	 * @param string $id
	 * @return PostThreadComment
	 */
	public function findById(string $id): PostThreadComment
	{
		return PostThreadComment::where('id', '=', $id)->firstOrFail();
	}

	/**
	 * Update a record.
	 * 
	 * @param array $data
	 * @param string $id
	 * @return PostThreadComment
	 */
	public function update(array $data, string $id): PostThreadComment
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
