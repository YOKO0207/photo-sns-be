<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Services\UserAuthService;
use App\Http\Requests\{
	AuthenticableUserAuthLoginRequest,
	AuthenticableUserAuthRegisterRequest
};

class UserAuthController extends Controller
{
	private UserAuthService $service;

	public function __construct(UserAuthService $service)
	{
		$this->service = $service;
	}

	/**
	 * Register an account.
	 * 
	 * @param AuthenticableUserAuthRegisterRequest $request
	 * @return JsonResponse
	 */
	public function register(AuthenticableUserAuthRegisterRequest $request): JsonResponse
	{
		return $this->service->register($request);
	}

	/**
	 * Login to an account.
	 * 
	 * @param AuthenticableUserAuthLoginRequest $request
	 * @return JsonResponse
	 */
	public function login(AuthenticableUserAuthLoginRequest $request): JsonResponse
	{
		return $this->service->login($request);
	}

	/**
	 * Login to an account.
	 * 
	 * @param  Request  $request
	 * @return JsonResponse
	 */
	public function logout(Request  $request): JsonResponse
	{
		return $this->service->logout($request);
	}
}
