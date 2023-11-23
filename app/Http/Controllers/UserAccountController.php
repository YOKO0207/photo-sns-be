<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Services\UserAccountService;
use App\Http\Requests\{
	UserEmailUpdateRequest,
	UserPasswordUpdateRequest,
	UserNameUpdateRequest
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
	 * @param UserEmailUpdateRequest $request
	 * @return JsonResponse
	 */
	public function updateEmail(UserEmailUpdateRequest $request): JsonResponse
	{
		return $this->service->updateEmail($request);
	}

	/**
	 * Update the specified resource in storage.
	 * 
	 * @param UserPasswordUpdateRequest $request
	 * @return JsonResponse
	 */
	public function updatePassword(UserPasswordUpdateRequest $request): JsonResponse
	{
		return $this->service->updatePassword($request);
	}

	/**
	 * Update the specified resource in storage.
	 * 
	 * @param UserNameUpdateRequest $request
	 * @return JsonResponse
	 */
	public function updateName(UserNameUpdateRequest $request): JsonResponse
	{
		return $this->service->updateName($request);
	}

	/**
	 * Remove the specified resource from storage.
	 * 
	 * @param  Request $request
	 * @return JsonResponse
	 */
	public function destroy(Request $request): JsonResponse
	{
		return $this->service->delete($request);
	}
}
