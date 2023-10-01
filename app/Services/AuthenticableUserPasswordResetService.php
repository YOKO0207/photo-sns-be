<?php

namespace App\Services;

use Illuminate\Http\JsonResponse;
use App\Repositories\Contracts\AuthenticableUserRepositoryInterface;
use App\Services\{CommonResponseService, CommonAuthenticableUserService};
use App\Http\Requests\{
	AuthenticableUserPasswordResetLinkSendRequest,
	AuthenticableUserPasswordResetRequest
};
use App\Constants\CommonResponseMessage;
use Illuminate\Support\Facades\Password;
use App\Exceptions\{UserNotExistException, TokenInvalidException};
use Symfony\Component\HttpKernel\Exception\TooManyRequestsHttpException;
use Illuminate\Support\Facades\Hash;

abstract class AuthenticableUserPasswordResetService
{
	private CommonResponseService $response;
	private ?CommonAuthenticableUserService $commonAuthenticableUserService = null;
	private ?AuthenticableUserRepositoryInterface $repository = null;

	/**
	 * Create a new service instance.
	 *
	 * @param CommonResponseService $response
	 */
	public function __construct(
		CommonResponseService $response,
	) {
		$this->response = $response;
	}

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
	 * Get the repository instance
	 */
	abstract protected function setRepository(): AuthenticableUserRepositoryInterface;
	/**
	 * Get the provider instance
	 */
	abstract protected function getProvider(): string;

	/**
	 * Handle a request to create a record
	 * 
	 * @param AuthenticableUserPasswordResetLinkSendRequest $request
	 * @return JsonResponse
	 */
	public function sendPasswordResetLink(AuthenticableUserPasswordResetLinkSendRequest $request): JsonResponse
	{
		// set instance(s) & variable(s)
		$this->getCommonAuthenticableUserService();

		// validate
		$data = $request->validated();
		$this->commonAuthenticableUserService->validateIfEmailExists($data['email']);

		// send password reset link
		$status = Password::broker($this->getProvider())->sendResetLink($request->only('email'));

		if ($status === Password::RESET_LINK_SENT) 
		{
			return $this->response->successResponse(
				message: CommonResponseMessage::PASSWORD_RESET_SEND
			);
		} else if ($status == Password::RESET_THROTTLED) {
			throw new TooManyRequestsHttpException("TooManyRequestsHttpException in AuthenticableUserPasswordResetService@sendPasswordResetLink");
		} else {
			throw new \Exception("Exception in AuthenticableUserPasswordResetService@sendPasswordResetLink");
		}
	}

	/**
	 * Handle a request to login to an account
	 * 
	 * @param AuthenticableUserPasswordResetRequest $request
	 * @return JsonResponse
	 */
	public function resetPassword(AuthenticableUserPasswordResetRequest $request): JsonResponse
	{
		// validate
		$request->validated();

		// reset password
		$status = Password::broker($this->getProvider())->reset(
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
			throw new UserNotExistException("UserNotExistException in AuthenticableUserPasswordResetService@resetPassword");
		} else if ($status == Password::INVALID_TOKEN) {
			throw new TokenInvalidException("TokenInvalidException in AuthenticableUserPasswordResetService@resetPassword");
		} else if ($status == Password::RESET_THROTTLED) {
			throw new TooManyRequestsHttpException("TooManyRequestsHttpException in AuthenticableUserPasswordResetService@resetPassword");
		} else {
			throw new \Exception("Exception in AuthenticableUserPasswordResetService@resetPassword");
		}
	}
}
