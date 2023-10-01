<?php

namespace App\Services;

use App\Repositories\Contracts\AuthenticableUserRepositoryInterface;
use App\Services\AuthenticableUserEmailVerificationService;

class UserEmailVerificationService extends AuthenticableUserEmailVerificationService
{
	private AuthenticableUserRepositoryInterface $repository;

	/**
	 * @param CommonResponseService $response
	 * @param AuthenticableUserRepositoryInterface $repository
	 */
	public function __construct(CommonResponseService $response, AuthenticableUserRepositoryInterface $repository)
	{
		parent::__construct($response);
		$this->repository = $repository;
	}

	protected function setRepository(): AuthenticableUserRepositoryInterface
	{
		return $this->repository;
	}
}