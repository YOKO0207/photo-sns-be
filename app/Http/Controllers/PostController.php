<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use App\Services\PostService;
use App\Http\Requests\PostCreateRequest;
use App\Models\Post;
use App\Http\ViewModels\{PostListViewModel, PostDetailViewModel};
use App\Constants\CommonResponseMessage;
use App\Traits\CommonResponseTrait;

class PostController extends Controller
{
	use CommonResponseTrait;
	private PostService $service;

	public function __construct(PostService $service)
	{
		$this->service = $service;
	}

	/**
	 * Display a listing of the resource.
	 * 
	 * @return JsonResponse
	 */
	public function index(): JsonResponse
	{
		$data = $this->service->getAll();
		$viewModel = new PostListViewModel($data);
		return $this->successResponse(
			message: CommonResponseMessage::INDEX_SUCCESS,
			data: $viewModel->data
		);
	}

	/**
	 * Store a newly created resource in storage.
	 * 
	 * @param PostCreateRequest $request
	 * @return JsonResponse
	 */
	public function store(PostCreateRequest $request): JsonResponse
	{
		$data = $this->service->create($request);
		$viewModel = new PostDetailViewModel($data);
		return $this->successResponse(
			message: CommonResponseMessage::CREATE_SUCCESS,
			data: $viewModel->data
		);
	}

	/**
	 * Display the specified resource.
	 * 
	 * @param string $id
	 * @return JsonResponse
	 */
	public function show(string $id): JsonResponse
	{
		$data = $this->service->getDetail($id);
		$viewModel = new PostDetailViewModel($data);
		return $this->successResponse(
			message: CommonResponseMessage::DETAIL_SUCCESS,
			data: $viewModel->data
		);
	}

	/**
	 * Remove the specified resource from storage.
	 * 
	 * @param Post $post
	 * @return JsonResponse
	 */
	public function destroy(Post $post): JsonResponse
	{
		$this->service->delete($post);
		return $this->successResponse(
			message: CommonResponseMessage::DELETE_SUCCESS
		);
	}
}
