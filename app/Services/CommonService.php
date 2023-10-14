<?php

namespace App\Services;

use Illuminate\Support\Facades\Auth;
use Illuminate\Auth\AuthenticationException;
use App\Models\{User};

class CommonService
{
	/**
	 * Find an authenticated user.
	 * 
	 * @return User
	 */
	public function getAuthenticatedUser(): User
	{
		$data = null;
		if (auth()->guard('user')->check()) {
			$data = Auth::guard('user')->user();
		}
		if (!$data) {
			throw new AuthenticationException("Cound not get a user in CommonAuthenticableUserService.php@getAuthenticatedUser");
		}
		return $data;
	}
}
