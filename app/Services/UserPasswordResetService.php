<?php

namespace App\Services;

use App\Services\CommonResponseService;
use Illuminate\Http\JsonResponse;
use App\Http\Requests\{
	UserPasswordResetLinkSendRequest,
	UserPasswordResetRequest
};
use App\Constants\CommonResponseMessage;
use Illuminate\Support\Facades\Password;
use App\Exceptions\{UserNotExistException, TokenInvalidException};
use Symfony\Component\HttpKernel\Exception\TooManyRequestsHttpException;
use Illuminate\Support\Facades\Hash;

class UserPasswordResetService
{
	private CommonResponseService $response;

	/**
	 * @param CommonResponseService $response
	 */
	public function __construct(
		CommonResponseService $response
	) {
		$this->response = $response;
	}

	/**
	 * Handle a request to create a record
	 * 
	 * @param UserPasswordResetLinkSendRequest $request
	 * @return JsonResponse
	 */
	public function sendPasswordResetLink(UserPasswordResetLinkSendRequest $request): JsonResponse
	{
		// validate
		$request->validated();

		// send password reset link
		$status = Password::broker('users')->sendResetLink($request->only('email'));

		if ($status === Password::RESET_LINK_SENT) {
			return $this->response->successResponse(
				message: CommonResponseMessage::PASSWORD_RESET_SEND
			);
		} else if ($status == Password::RESET_THROTTLED) {
			throw new TooManyRequestsHttpException("TooManyRequestsHttpException in UserPasswordResetService@sendPasswordResetLink");
		} else {
			throw new \Exception("Exception in UserPasswordResetService@sendPasswordResetLink");
		}
	}

	/**
	 * Handle a request to login to an account
	 * 
	 * @param UserPasswordResetRequest $request
	 * @return JsonResponse
	 */
	public function resetPassword(UserPasswordResetRequest $request): JsonResponse
	{
		// validate
		$request->validated();

		// reset password
		$status = Password::broker('users')->reset(
			$request->only('password', 'password_confirmation', 'token', 'email'),
			function ($user, $password) {
				$user->forceFill(['password' => Hash::make($password)])->save();
			}
		);


		if ($status === Password::PASSWORD_RESET) {
			return $this->response->successResponse(
				message: CommonResponseMessage::PASSWORD_RESET_SUCCESS
			);
		} else if ($status == Password::INVALID_USER) {
			throw new UserNotExistException("UserNotExistException in UserPasswordResetService@resetPassword");
		} else if ($status == Password::INVALID_TOKEN) {
			throw new TokenInvalidException("TokenInvalidException in UserPasswordResetService@resetPassword");
		} else if ($status == Password::RESET_THROTTLED) {
			throw new TooManyRequestsHttpException("TooManyRequestsHttpException in UserPasswordResetService@resetPassword");
		} else {
			throw new \Exception("Exception in UserPasswordResetService@resetPassword");
		}
	}
}