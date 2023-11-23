<?php

namespace App\Services;

use App\Repositories\Contracts\UserRepositoryInterface;
use App\Services\{CommonResponseService};
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Auth\Events\Registered;
use App\Http\Requests\{
	UserAuthRegisterRequest,
	UserAuthLoginRequest
};
use App\Constants\CommonResponseMessage;
use App\Http\ViewModels\{
	UserDetailViewModel,
	UserAuthenticatedDetailViewModel
};
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class UserAuthService
{
	private CommonResponseService $response;
	private UserRepositoryInterface $repository;

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
	 * Handle a request to create a record
	 * 
	 * @param UserAuthRegisterRequest $request
	 * @return JsonResponse
	 */
	public function register(UserAuthRegisterRequest $request): JsonResponse
	{
		// validate
		$data = $request->validated();

		// create a record
		$data = $this->repository->create($data);

		// send email verification
		event(new Registered($data));

		// return Json response
		return $this->response->successResponse(
			message: CommonResponseMessage::REGISTER_VERIFICATION_SUCCESS
		);
	}

	/**
	 * Handle a request to login to an account
	 * 
	 * @param UserAuthLoginRequest $request
	 * @return JsonResponse
	 */
	public function login(UserAuthLoginRequest $request): JsonResponse
	{
		// validate
		$user = $request->validated();
		$this->validateIfEmailVerified($user['email']);

		// generate token
		$user = $this->repository->findByEmail($user['email']);
		$token = $user->createToken('auth-token')->plainTextToken;

		// return Json response
		$user['accessToken'] = $token;
		$viewModel = new UserAuthenticatedDetailViewModel($user);
		return $this->response->successResponse(
			message: CommonResponseMessage::LOGIN_SUCCESS,
			data: $viewModel->data
		);
	}

	/**
	 * Handle a request to logout from an account
	 * 
	 * @param Request $request
	 * @return JsonResponse
	 */
	public function logout(Request $request): JsonResponse
	{
		$request->user()->currentAccessToken()->delete();

		// return Json response
		return $this->response->successResponse(
			message: CommonResponseMessage::LOGOUT_SUCCESS
		);
	}

	/**
	 * 
	 * Validate a user's email verification.
	 * 
	 * @param string $email
	 * @return void
	 */
	private function validateIfEmailVerified(string $email): void
	{
		$data = $this->repository->findByEmail($email);
		if (!$data->hasVerifiedEmail()) {
			$validator = Validator::make([], []); // Empty data and rules

			$validator->errors()->add('email', CommonResponseMessage::UNVERIFIED_USER);

			throw new ValidationException($validator);
		}
	}
}