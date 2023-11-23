<?php

namespace App\Services;

use Illuminate\Http\JsonResponse;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class MultiAuthService
{
	/**
	 * Handle a request to get an authenticated account
	 * 
	 * @return JsonResponse
	 */
	public function me(): User | null
	{
		$user = Auth::guard('api')->user();
		if ($user) {
			return $user;
		} else {
			return null;
		}
	}
}
