<?php

namespace App\Services;

use Illuminate\Http\JsonResponse;
use App\Http\Requests\UserEmailVerificationResendRequest;
use App\Services\CommonResponseService;
use App\Repositories\Contracts\UserRepositoryInterface;
use App\Constants\CommonResponseMessage;
use Illuminate\Auth\Events\Verified;
use Illuminate\Http\Request;
use Illuminate\Routing\Exceptions\InvalidSignatureException;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class UserEmailVerificationService
{
	private UserRepositoryInterface $repository;
	private CommonResponseService $response;

	/**
	 * @param CommonResponseService $response
	 * @param UserRepositoryInterface $repository
	 */
	public function __construct(CommonResponseService $response, UserRepositoryInterface $repository)
	{
		$this->repository = $repository;
		$this->response = $response;
	}

	/**
	 * Handle verifying a user.
	 * 
	 * @param Request $request
	 * @return JsonResponse
	 */
	public function verify(Request $request): JsonResponse
	{
		// validate
		/**
		 * when there is no user with a correct signature, it means the user is deleted.
		 */
		$this->validateIfIdExists($request->route('id'));
		$user = $this->repository->findById($request->route('id'));
		if (!hash_equals(sha1($user->getEmailForVerification()), (string) $request->route('hash'))) {
			throw new InvalidSignatureException("InvalidSignatureException in UserEmailVerificationService@verify");
		}
		$this->validateIfEmailAlreadyVerified($user);

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
		// validate
		/**
		 * when there is no user with a correct signature, it means the user is deleted.
		 */
		$this->validateIfIdExists($request->route('id'));
		$user = $this->repository->findById($request->route('id'));
		if (!hash_equals(sha1($user->getEmailForVerification()), (string) $request->route('hash'))) {
			throw new InvalidSignatureException("InvalidSignatureException in UserEmailVerificationService@verifyUpdateEmail");
		}
		$this->validateIfNewPendingEmailAlreadyVerified($user);

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
	 * @param UserEmailVerificationResendRequest $request
	 * @return JsonResponse
	 */
	public function resend(UserEmailVerificationResendRequest $request): JsonResponse
	{
		// validate
		$data = $request->validated();
		$user = $this->repository->findByEmail($data['email']);
		$this->validateIfEmailAlreadyVerified($user);

		// send verification email
		$user->sendEmailVerificationNotification();

		// return Json response
		return $this->response->successResponse(
			message: CommonResponseMessage::VERIFICATION_RESEND,
		);
	}

	/**
	 * 
	 * Validate if a user already verified
	 * 
	 * @param User $user
	 * @return void
	 */
	protected function validateIfEmailAlreadyVerified(User $user): void
	{
		//$data = $this->repository->findByEmail($email);
		if ($user->hasVerifiedEmail()) {
			$validator = Validator::make([], []); // Empty data and rules

			$validator->errors()->add('email', CommonResponseMessage::ALREADY_VERIFIED);

			throw new ValidationException($validator);
		}
	}

	/**
	 * 
	 * Validate if a user exists
	 * 
	 * @param string $id
	 * @return void
	 */
	protected function validateIfIdExists(string $id): void
	{
		if (!$this->repository->checkIfIdExists($id)) {
			$validator = Validator::make([], []); // Empty data and rules

			$validator->errors()->add('email', CommonResponseMessage::USER_ALREADY_DELETED);

			throw new ValidationException($validator);
		}
	}

	/**
	 * 
	 * Validata if a user's new pending email is already verified (= null)
	 * 
	 * @param User $user
	 * @return void
	 */
	protected function validateIfNewPendingEmailAlreadyVerified(User $user): void
	{
		if ($user->new_pending_email === null) {
			$validator = Validator::make([], []); // Empty data and rules

			$validator->errors()->add('email', CommonResponseMessage::ALREADY_VERIFIED);

			throw new ValidationException($validator);
		}
	}
}