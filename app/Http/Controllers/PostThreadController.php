<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use App\Constants\CommonResponseMessage;
use App\Services\PostThreadService;
use App\Http\Requests\{
	PostThreadCreateRequest,
	PostThreadUpdateRequest
};
use App\Models\{Post, PostThread};
use App\Http\ViewModels\{
	PostThreadDetailViewModel,
	PostThreadListViewModel,
};
use App\Traits\CommonResponseTrait;

class PostThreadController extends Controller
{
	use CommonResponseTrait;
	private PostThreadService $service;

	public function __construct(PostThreadService $service)
	{
		$this->service = $service;
	}

	/**
	 * Display a listing of the resource.
	 * 
	 * @param Post $post
	 * @return JsonResponse
	 */
	public function index(Post $post): JsonResponse
	{
		$data = $this->service->getAll($post);

		$viewModel = new PostThreadListViewModel($data);
		return $this->successResponse(
			message: CommonResponseMessage::INDEX_SUCCESS,
			data: $viewModel->data
		);
	}

	/**
	 * Store a newly created resource in storage.
	 * 
	 * @param PostThreadCreateRequest $request
	 * @param Post $post
	 * @return JsonResponse
	 */
	public function store(PostThreadCreateRequest $request, Post $post): JsonResponse
	{
		$data = $this->service->create($request, $post);

		$viewModel = new PostThreadDetailViewModel($data);
		return $this->successResponse(
			message: CommonResponseMessage::CREATE_SUCCESS,
			data: $viewModel->data
		);
	}

	/**
	 * Display the specified resource.
	 * 
	 * @param PostThread $postThread
	 * @return JsonResponse
	 */
	public function show(
		PostThread $postThread
		): JsonResponse
	{
		$data = $this->service->getDetail($postThread);
		$viewModel = new PostThreadDetailViewModel($data);
		return $this->successResponse(
			message: CommonResponseMessage::DETAIL_SUCCESS,
			data: $viewModel->data
		);
	}

	/**
	 * Update the specified resource in storage.
	 * 
	 * @param PostThreadUpdateRequest $request
	 * @param PostThread $postThread
	 * @return JsonResponse
	 */
	public function update(
		PostThreadUpdateRequest $request, 
		PostThread $postThread
		): JsonResponse
	{
		$data = $this->service->update($request, $postThread);

		$viewModel = new PostThreadDetailViewModel($data);
		return $this->successResponse(
			message: CommonResponseMessage::UPDATE_SUCCESS,
			data: $viewModel->data
		);
	}

	/**
	 * Remove the specified resource from storage.
	 * 
	 * @param PostThread $postThread
	 * @return JsonResponse
	 */
	public function destroy(
		PostThread $postThread
	): JsonResponse
	{
		$this->service->delete($postThread);
		return $this->successResponse(
			message: CommonResponseMessage::DELETE_SUCCESS
		);
	}
}
