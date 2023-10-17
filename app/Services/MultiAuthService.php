<?php

namespace App\Services;

use Illuminate\Http\JsonResponse;
use App\Services\{CommonService};
use App\Models\User;
use Illuminate\Support\Facades\Auth;

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
	public function me(): User | null
	{
		$data = null;
		if (auth()->guard('user')->check()) {
			$data = Auth::guard('user')->user();
		}
		return $data;
	}
}
