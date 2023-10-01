<?php

namespace App\Services;

use Illuminate\Http\JsonResponse;
use App\Http\Requests\AuthenticableUserEmailVerificationResendRequest;
use App\Services\CommonResponseService;
use App\Repositories\Contracts\AuthenticableUserRepositoryInterface;
use App\Constants\CommonResponseMessage;
use Illuminate\Auth\Events\Verified;
use Illuminate\Http\Request;
use Illuminate\Routing\Exceptions\InvalidSignatureException;

abstract class AuthenticableUserEmailVerificationService
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
		CommonResponseService $response
	) {
		$this->response = $response;
	}

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
	 * Handle verifying a user.
	 * 
	 * @param Request $request
	 * @return JsonResponse
	 */
	public function verify(Request $request): JsonResponse
	{
		// set instance(s) & variable(s)
		$this->getRepository();
		$this->getCommonAuthenticableUserService();

		// validate
		/**
		 * when there is no user with a correct signature, it means the user is deleted.
		 */
		$this->commonAuthenticableUserService->validateIfIdExists($request->route('id'));
		$user = $this->repository->findById($request->route('id'));
		if (!hash_equals(sha1($user->getEmailForVerification()), (string) $request->route('hash'))) {
			throw new InvalidSignatureException("InvalidSignatureException in AuthenticableUserEmailVerificationService@verify");
		}
		$this->commonAuthenticableUserService->validateIfEmailAlreadyVerified($user);

		// mark email as verified
		$user->markEmailAsVerified();
		event(new Verified($user));

		// return Json response
		return $this->response->successResponse(
			message: CommonResponseMessage::VERIFIED_SUCCESS,
		);
	}

	/**
	 * Handle a request to verify signed url, update email with new_pending_email, empty new_pending_email
	 * 
	 * @param Request $request
	 * @return JsonResponse
	 */
	public function verifyUpdateEmail(Request $request): JsonResponse
	{
		// set instance(s) & variable(s)
		$this->getCommonAuthenticableUserService();
		$this->getRepository();

		// validate
		/**
		 * when there is no user with a correct signature, it means the user is deleted.
		 */
		$this->commonAuthenticableUserService->validateIfIdExists($request->route('id'));
		$user = $this->repository->findById($request->route('id'));
		if (!hash_equals(sha1($user->getEmailForVerification()), (string) $request->route('hash'))) {
			throw new InvalidSignatureException("InvalidSignatureException in AuthenticableUserEmailVerificationService@verifyUpdateEmail");
		}
		$this->commonAuthenticableUserService->validateIfNewPendingEmailAlreadyVerified($user);

		// update email with new_pending_email, empty new_pending_email
		$updateData = [
			'email' => $user->new_pending_email,
			'new_pending_email' => null,
		];
		$this->repository->update($updateData, $user->id);

		// return Json response
		return $this->response->successResponse(
			message: CommonResponseMessage::VERIFIED_SUCCESS
		);
	}

	/**
	 * Handle resending a verification email to the user.
	 * 
	 * @param AuthenticableUserEmailVerificationResendRequest $request
	 * @return JsonResponse
	 */
	public function resend(AuthenticableUserEmailVerificationResendRequest $request): JsonResponse
	{
		// set instance(s)
		$this->getRepository();
		$this->getCommonAuthenticableUserService();

		// validate
		$data = $request->validated();
		$this->commonAuthenticableUserService->validateIfEmailExists($data['email']);
		$user = $this->repository->findByEmail($data['email']);
		$this->commonAuthenticableUserService->validateIfEmailAlreadyVerified($user);

		// send verification email
		$user->sendEmailVerificationNotification();

		// return Json response
		return $this->response->successResponse(
			message: CommonResponseMessage::VERIFICATION_RESEND,
		);
	}
}
