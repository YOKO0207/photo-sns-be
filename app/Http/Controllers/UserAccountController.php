<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Services\UserAccountService;
use App\Http\Requests\{
	AuthenticableUserEmailUpdateRequest,
	AuthenticableUserPasswordUpdateRequest,
	AuthenticableUserNameUpdateRequest
};

class UserAccountController extends Controller
{
	private UserAccountService $service;

	public function __construct(UserAccountService $service)
	{
		$this->service = $service;
	}

	/**
	 * Update the specified resource in storage.
	 * 
	 * @param AuthenticableUserEmailUpdateRequest $request
	 * @return JsonResponse
	 */
	public function updateEmail(AuthenticableUserEmailUpdateRequest $request): JsonResponse
	{
		return $this->service->updateEmail($request);
	}

	/**
	 * Update the specified resource in storage.
	 * 
	 * @param AuthenticableUserPasswordUpdateRequest $request
	 * @return JsonResponse
	 */
	public function updatePassword(AuthenticableUserPasswordUpdateRequest $request): JsonResponse
	{
		return $this->service->updatePassword($request);
	}

	/**
	 * Update the specified resource in storage.
	 * 
	 * @param AuthenticableUserNameUpdateRequest $request
	 * @return JsonResponse
	 */
	public function updateName(AuthenticableUserNameUpdateRequest $request): JsonResponse
	{
		return $this->service->updateName($request);
	}

	/**
	 * Remove the specified resource from storage.
	 * 
	 * @param  Request  $request
	 * @return JsonResponse
	 */
	public function destroy(): JsonResponse
	{
		return $this->service->delete();
	}
}
