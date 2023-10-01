<?php

namespace App\Services;

use App\Models\Contracts\AuthenticableUser;
use Illuminate\Support\Facades\Validator;
use App\Constants\CommonResponseMessage;
use Illuminate\Validation\ValidationException;
use App\Repositories\Contracts\AuthenticableUserRepositoryInterface;

class CommonAuthenticableUserService
{
	private AuthenticableUserRepositoryInterface $repository;

	/**
	 * 
	 * @param AuthenticableUserRepositoryInterface $repository
	 */
	public function __construct(AuthenticableUserRepositoryInterface $repository)
	{
		$this->repository = $repository;
	}

	/**
	 * Below validation can be handled in request class
	 * However I am injecting repository in classed that inherits this class
	 * So I can't use repository dependent validation rules in request class
	 * That's why I am making these validation methods in this class
	 */

	/**
	 * 
	 * Validate a user's email verification.
	 * 
	 * @param string $email
	 * @return void
	 */
	public function validateIfEmailVerified(string $email): void
	{
		$data = $this->repository->findByEmail($email);
		if (!$data->hasVerifiedEmail()) {
			$validator = Validator::make([], []); // Empty data and rules

			$validator->errors()->add('email', CommonResponseMessage::UNVERIFIED_USER);

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
	public function validateIfIdExists(string $id): void
	{
		if (!$this->repository->checkIfIdExists($id)) {
			$validator = Validator::make([], []); // Empty data and rules

			$validator->errors()->add('email', CommonResponseMessage::USER_ALREADY_DELETED);

			throw new ValidationException($validator);
		}
	}

	/**
	 * 
	 * Validate if a user exists
	 * 
	 * @param string $email
	 * @return void
	 */
	public function validateIfEmailExists(string $email): void
	{
		if (!$this->repository->checkIfEmailExists($email)) {
			$validator = Validator::make([], []); // Empty data and rules

			$validator->errors()->add('email', CommonResponseMessage::EMAIL_NOT_EXIST);

			throw new ValidationException($validator);
		}
	}

	/**
	 * 
	 * Return json validation error response
	 * 
	 * @return void
	 */
	public function returnLoginFail(): void
	{
		$validator = Validator::make([], []); // Empty data and rules

		$validator->errors()->add('password', CommonResponseMessage::PASSWORD_INCORRECT);

		throw new ValidationException($validator);
	}

	/**
	 * 
	 * Validate if a user exists
	 * 
	 * @param string $email
	 * @return void
	 */
	public function validateIfEmailUnique(string $email): void
	{
		if ($this->repository->checkIfEmailExists($email)) {
			$validator = Validator::make([], []); // Empty data and rules

			$validator->errors()->add('email', CommonResponseMessage::EMAIL_ALREADY_EXIST);

			throw new ValidationException($validator);
		}
	}

	/**
	 * 
	 * Validate if a user already verified
	 * 
	 * @param AuthenticableUser $user
	 * @return void
	 */
	public function validateIfEmailAlreadyVerified(AuthenticableUser $user): void
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
	 * Validata if a user's new pending email is already verified (= null)
	 * 
	 * @param AuthenticableUser $user
	 * @return void
	 */
	public function validateIfNewPendingEmailAlreadyVerified(AuthenticableUser $user): void
	{
		if ($user->new_pending_email === null) {
			$validator = Validator::make([], []); // Empty data and rules

			$validator->errors()->add('email', CommonResponseMessage::ALREADY_VERIFIED);

			throw new ValidationException($validator);
		}
	}
}
