<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use App\Services\MultiAuthService;
use App\Traits\CommonResponseTrait;
use App\Http\ViewModels\AuthenticableUserDetailViewModel;
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
		$viewModel = new AuthenticableUserDetailViewModel($data);
		return $this->successResponse(
			message: CommonResponseMessage::DETAIL_SUCCESS,
			data: $viewModel->data
		);
	}
}
