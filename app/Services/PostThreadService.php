<?php

namespace App\Services;

use Illuminate\Pagination\LengthAwarePaginator;
use App\Services\CommonService;
use App\Http\Requests\{
	PostThreadCreateRequest,
	PostThreadUpdateRequest
};
use App\Models\{Post, PostThread};
use App\Repositories\Contracts\ScopedListableCrudRepositoryInterface;

class PostThreadService
{
	private CommonService $commonService;
	private ScopedListableCrudRepositoryInterface $repository;

	/**
	 * Create a new service instance.
	 *
	 * @param CommonService $commonService
	 * @param ScopedListableCrudRepositoryInterface $repository
	 */
	public function __construct(
		CommonService $commonService,
		ScopedListableCrudRepositoryInterface $repository,
	) {
		$this->commonService = $commonService;
		$this->repository = $repository;
	}

	/**
	 * Handle a request to get a paginated list
	 * 
	 * @param int @pagination
	 * @param Post $post
	 * @return LengthAwarePaginator
	 */
	public function getAllPaginated(int $pagination, Post $post): LengthAwarePaginator
	{
		return $this->repository->findAllPaginated($pagination, $post->id);
	}

	/**
	 * Handle a request to get a list
	 * 
	 * @param Post $post
	
	 */
	public function getAll(Post $post)
	{
		return $this->repository->findAll($post->id);
	}

	/**
	 * Handle a request to create a record
	 * 
	 * @param PostThreadCreateRequest $request
	 * @param Post $post
	 * @return PostThread
	 */
	public function create(
		PostThreadCreateRequest $request,
		Post $post
		): PostThread
	{
		$data = $request->validated();
		$data['post_id'] = $post->id;
		$user = $this->commonService->getAuthenticatedUser();
		$data['user_id'] = $user->id;

		return $this->repository->create($data);
	}

	/**
	 * Handle a request to get a record
	 * 
	 * @param PostThread $postThread
	 * @return PostThread
	 */
	public function getDetail(
		PostThread $postThread
	): PostThread
	{
		return $postThread;
	}

	/**
	 * Handle a request to update a record
	 * 
	 * @param PostThreadUpdateRequest $request
	 * @param PostThread $postThread
	 * @return PostThread
	 */
	public function update(
		PostThreadUpdateRequest $request,
		PostThread $postThread
		): PostThread
	{
		$data = $request->validated();
		return $this->repository->update($data, $postThread->id);
	}

	/**
	 * Handle a request to delete a record
	 * 
	 * @param PostThread $postThread
	 * @return void
	 */
	public function delete(
		PostThread $postThread
	): void
	{
		$this->repository->delete($postThread->id);
	}
}
