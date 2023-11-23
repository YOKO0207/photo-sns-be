<?php

namespace App\Services;

use App\Repositories\Contracts\UserRepositoryInterface;
use Illuminate\Http\JsonResponse;
use App\Services\{CommonResponseService};
use App\Http\Requests\{
	UserEmailUpdateRequest,
	UserPasswordUpdateRequest,
	UserNameUpdateRequest
};
use App\Constants\CommonResponseMessage;
use Illuminate\Http\Request;

class UserAccountService
{
	private UserRepositoryInterface $repository;
	private CommonResponseService $response;

	/**
	 * @param CommonResponseService $response
	 * @param UserRepositoryInterface $repository
	 */
	public function __construct(
		CommonResponseService $response,
		UserRepositoryInterface $repository
	) {
		$this->repository = $repository;
		$this->response = $response;
	}

	/**
	 * Handle a sending a verification email and update new_pending_email
	 * 
	 * @param UserEmailUpdateRequest $request
	 * @return JsonResponse
	 */
	public function updateEmail(UserEmailUpdateRequest $request): JsonResponse
	{
		$user = $request->user();

		// validate
		$data = $request->validated();

		// update new_pending_email
		$updateData = ['new_pending_email' => $data['email']];
		$model = $this->repository->update($updateData, $user->id);

		// send verification email
		$model->sendEmailUpdateVerificationNotification();

		// return Json response
		return $this->response->successResponse(
			message: CommonResponseMessage::VERIFICATION_SEND
		);
	}

	/**
	 * Handle a request to update a record
	 * 
	 * @param UserPasswordUpdateRequest $request
	 * @return JsonResponse
	 */
	public function updatePassword(UserPasswordUpdateRequest $request): JsonResponse
	{
		$user = $request->user();

		// validate
		$data = $request->validated();

		// update password
		$updateData = ['password' => $data['password']];
		$model = $this->repository->update($updateData, $user->id);

		// return Json response
		return $this->response->successResponse(
			message: CommonResponseMessage::UPDATE_SUCCESS
		);
	}

	/**
	 * Handle a request to update a record
	 * 
	 * @param UserNameUpdateRequest $request
	 * @return JsonResponse
	 */
	public function updateName(UserNameUpdateRequest $request): JsonResponse
	{
		// set instance(s) and variable(s)
		$user = $request->user();

		// validate
		$data = $request->validated();

		// update name
		$updateData = ['name' => $data['name']];
		$model = $this->repository->update($updateData, $user->id);

		// return Json response
		return $this->response->successResponse(
			message: CommonResponseMessage::UPDATE_SUCCESS
		);
	}

	/**
	 * Handle a request to delete a record
	 * 
	 * @return JsonResponse
	 */
	public function delete(Request $request): JsonResponse
	{
		// set instance(s) & variable(s)
		$user = $request->user();

		// delete record
		$this->repository->delete($user->id);

		// return Json response
		return $this->response->successResponse(
			message: CommonResponseMessage::DELETE_SUCCESS
		);
	}
}
