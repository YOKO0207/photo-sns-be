<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use App\Http\Requests\UserEmailVerificationResendRequest;
use App\Services\UserEmailVerificationService;

use Illuminate\Http\Request;

class UserEmailVerificationController extends Controller
{
	private UserEmailVerificationService $service;

	public function __construct(UserEmailVerificationService $service)
	{
		$this->service = $service;
	}

	/**
	 * Send a verification email to the user.
	 * 
	 * @param Request $request
	 * @return JsonResponse
	 */
	public function verify(Request $request): JsonResponse
	{
		return $this->service->verify($request);
	}

	/**
	 * Send a verification email to the user.
	 * 
	 * @param Request $request
	 * @return JsonResponse
	 */
	public function verifyUpdateEmail(Request $request): JsonResponse
	{
		return $this->service->verifyUpdateEmail($request);
	}

	/**
	 * Resend a verification email to the user.
	 * 
	 * @param UserEmailVerificationResendRequest $request
	 * @return JsonResponse
	 */
	public function resend(UserEmailVerificationResendRequest $request): JsonResponse
	{
		return $this->service->resend($request);
	}
}
