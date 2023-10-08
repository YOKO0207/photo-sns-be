<?php

namespace App\Services;

use Illuminate\Pagination\LengthAwarePaginator;
use App\Services\CommonService;
use App\Http\Requests\{
	PostThreadCommentCreateRequest,
	PostThreadCommentUpdateRequest
};
use App\Models\{PostThread, PostThreadComment};
use App\Repositories\Contracts\ScopedListableCrudRepositoryInterface;

class PostThreadCommentService
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
	 * @param PostThread $postThread
	 * @return LengthAwarePaginator
	 */
	public function getAllPaginated(int $pagination, PostThread $postThread): LengthAwarePaginator
	{
		return $this->repository->findAllPaginated($pagination, $postThread->id);
	}

	/**
	 * Handle a request to get a list
	 * 
	 * @param PostThread $postThread
	
	 */
	public function getAll(PostThread $postThread)
	{
		return $this->repository->findAll($postThread->id);
	}

	/**
	 * Handle a request to create a record
	 * 
	 * @param PostThreadCommentCreateRequest $request
	 * @param PostThread $postThread
	 * @return PostThreadComment
	 */
	public function create(
		PostThreadCommentCreateRequest $request,
		PostThread $postThread
		): PostThreadComment
	{
		$data = $request->validated();
		$data['post_thread_id'] = $postThread->id;
		$user = $this->commonService->getAuthenticatedUser();
		$data['user_id'] = $user->id;

		return $this->repository->create($data);
	}

	/**
	 * Handle a request to get a record
	 * 
	 * @param PostThreadComment $postThreadComment
	 * @return PostThreadComment
	 */
	public function getDetail(
		PostThreadComment $postThreadComment
	): PostThreadComment
	{
		return $postThreadComment;
	}

	/**
	 * Handle a request to update a record
	 * 
	 * @param PostThreadCommentUpdateRequest $request
	 * @param PostThreadComment $postThreadComment
	 * @return PostThreadComment
	 */
	public function update(
		PostThreadCommentUpdateRequest $request,
		PostThreadComment $postThreadComment
		): PostThreadComment
	{
		$data = $request->validated();
		return $this->repository->update($data, $postThreadComment->id);
	}

	/**
	 * Handle a request to delete a record
	 * 
	 * @param PostThreadComment $postThreadComment
	 * @return void
	 */
	public function delete(
		PostThreadComment $postThreadComment
	): void
	{
		$this->repository->delete($postThreadComment->id);
	}
}
