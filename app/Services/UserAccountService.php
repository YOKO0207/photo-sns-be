<?php

namespace App\Services;

use App\Repositories\Contracts\AuthenticableUserRepositoryInterface;
use App\Services\{CommonResponseService, CommonService};
use App\Services\{AuthenticableUserAccountService};

class UserAccountService extends AuthenticableUserAccountService
{
	private AuthenticableUserRepositoryInterface $repository;

	/**
	 * @param CommonResponseService $response
	 * @param CommonService $commonService
	 * @param AuthenticableUserRepositoryInterface $repository
	 */
	public function __construct(
		CommonResponseService $response,
		CommonService $commonService,
		AuthenticableUserRepositoryInterface $repository
	) {
		parent::__construct($response, $commonService);
		$this->repository = $repository;
	}

	protected function setRepository(): AuthenticableUserRepositoryInterface
	{
		return $this->repository;
	}
}
