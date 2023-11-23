<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use App\Services\UserPasswordResetService;
use App\Http\Requests\{UserPasswordResetLinkSendRequest, UserPasswordResetRequest};

class UserPasswordResetController extends Controller
{
	private UserPasswordResetService $service;

	public function __construct(UserPasswordResetService $service)
	{
		$this->service = $service;
	}

	/**
	 * Send password reset link.
	 * 
	 * @param UserPasswordResetLinkSendRequest $request
	 * @return JsonResponse
	 */
	public function sendPasswordResetLink(UserPasswordResetLinkSendRequest $request): JsonResponse
	{
		return $this->service->sendPasswordResetLink($request);
	}

	/**
	 * Reset password.
	 * 
	 * @param UserPasswordResetRequest $request
	 * @return JsonResponse
	 */
	public function resetPassword(UserPasswordResetRequest $request): JsonResponse
	{
		return $this->service->resetPassword($request);
	}
}
