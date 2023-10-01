<?php

namespace App\Services;

use App\Repositories\Contracts\AuthenticableUserRepositoryInterface;
use App\Services\CommonResponseService;
use App\Services\AuthenticableUserPasswordResetService;

class UserPasswordResetService extends AuthenticableUserPasswordResetService
{
	private AuthenticableUserRepositoryInterface $repository;

	/**
	 * @param CommonResponseService $response
	 * @param AuthenticableUserRepositoryInterface $repository
	 */
	public function __construct(
		CommonResponseService $response,
		AuthenticableUserRepositoryInterface $repository
	) {
		parent::__construct($response);
		$this->repository = $repository;
	}

	protected function setRepository(): AuthenticableUserRepositoryInterface
	{
		return $this->repository;
	}

	protected function getProvider(): string
	{
		return 'users';
	}
}