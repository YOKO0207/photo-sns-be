<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use App\Constants\CommonResponseMessage;
use App\Services\PostThreadCommentService;
use App\Http\Requests\{
	PostThreadCommentCreateRequest,
	PostThreadCommentUpdateRequest
};
use App\Models\{PostThread, PostThreadComment};
use App\Http\ViewModels\{
	PostThreadCommentDetailViewModel,
	PostThreadCommentListViewModel,
};
use App\Traits\CommonResponseTrait;

class PostThreadCommentController extends Controller
{
	use CommonResponseTrait;
	private PostThreadCommentService $service;

	public function __construct(PostThreadCommentService $service)
	{
		$this->service = $service;
	}

	/**
	 * Display a listing of the resource.
	 * 
	 * @param PostThread $postThread
	 * @return JsonResponse
	 */
	public function index(PostThread $postThread): JsonResponse
	{
		$data = $this->service->getAll($postThread);

		$viewModel = new PostThreadCommentListViewModel($data);
		return $this->successResponse(
			message: CommonResponseMessage::INDEX_SUCCESS,
			data: $viewModel->data
		);
	}

	/**
	 * Store a newly created resource in storage.
	 * 
	 * @param PostThreadCommentCreateRequest $request
	 * @param PostThread $postThread
	 * @return JsonResponse
	 */
	public function store(PostThreadCommentCreateRequest $request, PostThread $postThread): JsonResponse
	{
		$data = $this->service->create($request, $postThread);

		$viewModel = new PostThreadCommentDetailViewModel($data);
		return $this->successResponse(
			message: CommonResponseMessage::CREATE_SUCCESS,
			data: $viewModel->data
		);
	}

	/**
	 * Display the specified resource.
	 * 
	 * @param PostThreadComment $postThreadComment
	 * @return JsonResponse
	 */
	public function show(
		PostThreadComment $postThreadComment
		): JsonResponse
	{
		$data = $this->service->getDetail($postThreadComment);
		$viewModel = new PostThreadCommentDetailViewModel($data);
		return $this->successResponse(
			message: CommonResponseMessage::DETAIL_SUCCESS,
			data: $viewModel->data
		);
	}

	/**
	 * Update the specified resource in storage.
	 * 
	 * @param PostThreadCommentUpdateRequest $request
	 * @param PostThreadComment $postThreadComment
	 * @return JsonResponse
	 */
	public function update(
		PostThreadCommentUpdateRequest $request,
		PostThreadComment $postThreadComment
		): JsonResponse
	{
		$data = $this->service->update($request, $postThreadComment);

		$viewModel = new PostThreadCommentDetailViewModel($data);
		return $this->successResponse(
			message: CommonResponseMessage::UPDATE_SUCCESS,
			data: $viewModel->data
		);
	}

	/**
	 * Remove the specified resource from storage.
	 * 
	 * @param PostThreadComment $postThreadComment
	 * @return JsonResponse
	 */
	public function destroy(
		PostThreadComment $postThreadComment
	): JsonResponse
	{
		$this->service->delete($postThreadComment);
		return $this->successResponse(
			message: CommonResponseMessage::DELETE_SUCCESS
		);
	}
}
