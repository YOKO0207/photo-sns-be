<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use App\Services\MultiAuthService;
use App\Traits\CommonResponseTrait;
use App\Http\ViewModels\UserDetailViewModel;
use App\Constants\CommonResponseMessage;

class MultiAuthController extends Controller
{
	use CommonResponseTrait;
	private MultiAuthService $service;

	public function __construct(MultiAuthService $service)
	{
		$this->service = $service;
	}

	/**
	 * Return authenticated resource.
	 * 
	 * @return JsonResponse
	 */
	public function me(): JsonResponse
	{
		$data = $this->service->me();
		if ($data) {
			$viewModel = new UserDetailViewModel($data);
			return $this->successResponse(
				message: CommonResponseMessage::DETAIL_SUCCESS,
				data: $viewModel->data
			);
		} else {
			return $this->successResponse(
				message: CommonResponseMessage::NOT_EXIST_AUTHENTICATED_USER,
				data: []
			);
		}
	}
}
