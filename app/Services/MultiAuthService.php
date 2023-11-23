<?php

namespace App\Services;

use Illuminate\Http\JsonResponse;
use App\Models\User;
use Illuminate\Http\Request;

class MultiAuthService
{
	/**
	 * Handle a request to get an authenticated account
	 * 
	 * @return JsonResponse
	 */
	public function me(Request $request): User | null
	{
		return $request->user();
	}
}
