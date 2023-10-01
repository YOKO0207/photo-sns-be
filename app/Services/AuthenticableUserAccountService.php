<?php

namespace App\Services;

use Illuminate\Http\JsonResponse;
use App\Repositories\Contracts\AuthenticableUserRepositoryInterface;
use App\Services\{CommonResponseService, CommonAuthenticableUserService, CommonService};
use App\Http\Requests\{
	AuthenticableUserEmailUpdateRequest,
	AuthenticableUserPasswordUpdateRequest,
	AuthenticableUserNameUpdateRequest
};
use App\Constants\CommonResponseMessage;
use App\Http\ViewModels\{
	AuthenticableUserDetailViewModel,
	AuthenticableUserEmailUpdateDetailViewModel
};

abstract class AuthenticableUserAccountService
{
	private CommonResponseService $response;
	private CommonService $commonService;
	private ?CommonAuthenticableUserService $commonAuthenticableUserService = null;
	private ?AuthenticableUserRepositoryInterface $repository = null;

	/**
	 * Create a new service instance.
	 *
	 * @param CommonResponseService $response
	 * @param CommonService $commonService
	 */
	public function __construct(
		CommonResponseService $response,
		CommonService $commonService
	) {
		$this->response = $response;
		$this->commonService = $commonService;
	}

	/**
	 * Get the repository instance
	 */
	abstract protected function setRepository(): AuthenticableUserRepositoryInterface;

	/**
	 * Lazy load the repository instance untill it is needed
	 */
	protected function getRepository(): void
	{
		if ($this->repository === null) {
			$this->repository = $this->setRepository();
		}
	}

	/**
	 * Lazy load the common service instance untill it is needed
	 */
	protected function getCommonAuthenticableUserService(): void
	{
		if ($this->commonAuthenticableUserService === null) {
			$this->commonAuthenticableUserService = new CommonAuthenticableUserService($this->setRepository());
		}
	}


	/**
	 * Handle a sending a verification email and update new_pending_email
	 * 
	 * @param AuthenticableUserEmailUpdateRequest $request
	 * @return JsonResponse
	 */
	public function updateEmail(AuthenticableUserEmailUpdateRequest $request): JsonResponse
	{
		// set instance(s) & variable(s)
		$this->getCommonAuthenticableUserService();
		$this->getRepository();
		$user = $this->commonService->getAuthenticatedUser();

		// validate
		$data = $request->validated();
		$this->commonAuthenticableUserService->validateIfEmailUnique($data['email']);

		// update new_pending_email
		$updateData = ['new_pending_email' => $data['email']];
		$model = $this->repository->update($updateData, $user->id);

		// send verification email
		$model->sendEmailUpdateVerificationNotification();

		// return Json response
		$viewModel = new AuthenticableUserEmailUpdateDetailViewModel($model);
		return $this->response->successResponse(
			message: CommonResponseMessage::VERIFICATION_SEND,
			data: $viewModel->data
		);
	}

	/**
	 * Handle a request to update a record
	 * 
	 * @param AuthenticableUserPasswordUpdateRequest $request
	 * @return JsonResponse
	 */
	public function updatePassword(AuthenticableUserPasswordUpdateRequest $request): JsonResponse
	{
		// set instance(s) and variable(s)
		$this->getRepository();
		$user = $this->commonService->getAuthenticatedUser();

		// validate
		$data = $request->validated();
		
		// update password
		$updateData = ['password' => $data['password']];
		$model = $this->repository->update($updateData, $user->id);

		// return Json response
		$viewModel = new AuthenticableUserDetailViewModel($model);
		return $this->response->successResponse(
			message: CommonResponseMessage::UPDATE_SUCCESS,
			data: $viewModel->data
		);
	}

	/**
	 * Handle a request to update a record
	 * 
	 * @param AuthenticableUserNameUpdateRequest $request
	 * @return JsonResponse
	 */
	public function updateName(AuthenticableUserNameUpdateRequest $request): JsonResponse
	{
		// set instance(s) and variable(s)
		$this->getRepository();
		$user = $this->commonService->getAuthenticatedUser();

		// validate
		$data = $request->validated();
		
		// update name
		$updateData = ['name' => $data['name']];
		$model = $this->repository->update($updateData, $user->id);

		// return Json response
		$viewModel = new AuthenticableUserDetailViewModel($model);
		return $this->response->successResponse(
			message: CommonResponseMessage::UPDATE_SUCCESS,
			data: $viewModel->data
		);
	}

	/**
	 * Handle a request to delete a record
	 * 
	 * @return JsonResponse
	 */
	public function delete(): JsonResponse
	{
		// set instance(s) & variable(s)
		$this->getRepository();
		$user = $this->commonService->getAuthenticatedUser();

		// delete record
		$this->repository->delete($user->id);

		// return Json response
		return $this->response->successResponse(
			message: CommonResponseMessage::DELETE_SUCCESS
		);
	}
}
