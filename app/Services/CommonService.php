<?php

namespace App\Services;

use Illuminate\Support\Facades\Auth;
use Illuminate\Auth\AuthenticationException;
use App\Models\{User, CompanyStaff, PhotoCreative, PhotoThumbnail, PhotoThread, PhotoProject};
use Illuminate\Auth\Access\AuthorizationException;

class CommonService
{
	/**
	 * Find an authenticated user.
	 * 
	 * @return Client | CompanyStaff
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

	// /**
	//  * Handle autorization check
	//  * 
	//  * @param PhotoProject $photo_project
	//  * @return void
	//  */
	// public function checkClientAuthorizationWithPhotoProject(PhotoProject $photo_project): void
	// {
	// 	$user = $this->getAuthenticatedUser();
	// 	if (($user instanceof Client && $user->id !== $photo_project->client_id)
	// 		|| ($user instanceof Client && $photo_project->client_id == null)
	// 	) {
	// 		throw new AuthorizationException("AuthorizationException in PhotoMaterialService@checkClientAuthorization");
	// 	}
	// }

	// /**
	//  * Handle autorization check
	//  * 
	//  * @param PhotoThumbnail $photo_thumbnail
	//  * @return void
	//  */
	// public function checkClientAuthorizationWithPhotoThumbnail(PhotoThumbnail $photo_thumbnail): void
	// {
	// 	$user = $this->getAuthenticatedUser();
	// 	if (($user instanceof Client && $user->id !== $photo_thumbnail->photoProject->client_id)
	// 		|| ($user instanceof Client && $photo_thumbnail->photoProject->client_id == null)
	// 	) {
	// 		throw new AuthorizationException("AuthorizationException in PhotoCreativeService@checkClientAuthorization");
	// 	}
	// }

	// /**
	//  * Handle autorization check
	//  * 
	//  * @param PhotoCreative $photo_creative
	//  * @return void
	//  */
	// public function checkClientAuthorizationWithPhotoCreative(PhotoCreative $photo_creative): void
	// {
	// 	$user = $this->getAuthenticatedUser();
	// 	if (($user instanceof Client && $user->id !== $photo_creative->photoThumbnail->photoProject->client_id)
	// 		|| ($user instanceof Client && $photo_creative->photoThumbnail->photoProject->client_id == null)
	// 	) {
	// 		throw new AuthorizationException("AuthorizationException in PhotoThreadService@checkClientAuthorization");
	// 	}
	// }

	// /**
	//  * Handle autorization check
	//  * 
	//  * @param PhotoThread $photo_thread
	//  * @return void
	//  */
	// public function checkClientAuthorizationWithPhotoThread(PhotoThread $photo_thread): void
	// {
	// 	$user = $this->getAuthenticatedUser();
	// 	if (($user instanceof Client && $user->id !== $photo_thread->photoCreative->photoThumbnail->photoProject->client_id)
	// 		|| ($user instanceof Client && $photo_thread->photoCreative->photoThumbnail->photoProject->client_id == null)
	// 	) {
	// 		throw new AuthorizationException("AuthorizationException in PhotoCommentService@checkClientAuthorization");
	// 	}
	// }
}
