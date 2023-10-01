<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use App\Services\UserPasswordResetService;
use App\Http\Requests\{AuthenticableUserPasswordResetLinkSendRequest, AuthenticableUserPasswordResetRequest};

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
	 * @param AuthenticableUserPasswordResetLinkSendRequest $request
	 * @return JsonResponse
	 */
	public function sendPasswordResetLink(AuthenticableUserPasswordResetLinkSendRequest $request): JsonResponse
	{
		return $this->service->sendPasswordResetLink($request);
	}

	/**
	 * Reset password.
	 * 
	 * @param AuthenticableUserPasswordResetRequest $request
	 * @return JsonResponse
	 */
	public function resetPassword(AuthenticableUserPasswordResetRequest $request): JsonResponse
	{
		return $this->service->resetPassword($request);
	}
}
