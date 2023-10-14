<?php

namespace App\Services;

use Illuminate\Http\JsonResponse;
use App\Services\{CommonService};
use App\Models\User;

class MultiAuthService
{
	private CommonService $commonService;

	/**
	 * Create a new service instance.
	 *
	 * @param CommonService $commonService
	 */
	public function __construct(
		CommonService $commonService
	) {
		$this->commonService = $commonService;
	}

	/**
	 * Handle a request to get an authenticated account
	 * 
	 * @return JsonResponse
	 */
	public function me(): User
	{
		return $this->commonService->getAuthenticatedUser();
	}
}
