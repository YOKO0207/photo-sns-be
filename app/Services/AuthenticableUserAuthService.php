<?php

namespace App\Services;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Auth;
use App\Repositories\Contracts\AuthenticableUserRepositoryInterface;
use App\Services\{CommonResponseService, CommonAuthenticableUserService, CommonService};
use App\Http\Requests\{
	AuthenticableUserAuthRegisterRequest,
	AuthenticableUserAuthLoginRequest
};
use App\Constants\CommonResponseMessage;
use App\Http\ViewModels\{
	AuthenticableUserDetailViewModel
};

abstract class AuthenticableUserAuthService
{
	private CommonResponseService $response;
	private CommonService $commonService;
	private ?CommonAuthenticableUserService $commonAuthenticableUserService = null;
	private ?AuthenticableUserRepositoryInterface $repository = null;

	/**
	 * Create a new service instance.
	 *
	 * @param CommonResponseService $response
	 * @param CommonService $commonService
	 */
	public function __construct(
		CommonResponseService $response,
		CommonService $commonService
	) {
		$this->response = $response;
		$this->commonService = $commonService;
	}

	/**
	 * Lazy load the repository instance untill it is needed
	 */
	protected function getRepository(): void
	{
		if ($this->repository === null) {
			$this->repository = $this->setRepository();
		}
	}

	/**
	 * Lazy load the common service instance untill it is needed
	 */
	protected function getCommonAuthenticableUserService(): void
	{
		if ($this->commonAuthenticableUserService === null) {
			$this->commonAuthenticableUserService = new CommonAuthenticableUserService($this->setRepository());
		}
	}

	/**
	 * Get the repository instance
	 */
	abstract protected function setRepository(): AuthenticableUserRepositoryInterface;
	/**
	 * Get the guard instance
	 */
	abstract protected function getGuard(): string;
	/**
	 * Get the guard instance
	 */

	/**
	 * Handle a request to create a record
	 * 
	 * @param AuthenticableUserAuthRegisterRequest $request
	 * @return JsonResponse
	 */
	public function register(AuthenticableUserAuthRegisterRequest $request): JsonResponse
	{
		// set instance(s) & variable(s)
		$this->getCommonAuthenticableUserService();
		$this->getRepository();

		// validate
		$data = $request->validated();
		$this->commonAuthenticableUserService->validateIfEmailUnique($data['email']);

		// create a record
		$data = $this->repository->create($data);
		
		// send email verification
		event(new Registered($data)); 

		// return Json response
		$viewModel = new AuthenticableUserDetailViewModel($data);
		return $this->response->successResponse(
			message: CommonResponseMessage::REGISTER_VERIFICATION_SUCCESS,
			data: $viewModel->data
		);
	}

	/**
	 * Handle a request to login to an account
	 * 
	 * @param AuthenticableUserAuthLoginRequest $request
	 * @return JsonResponse
	 */
	public function login(AuthenticableUserAuthLoginRequest $request): JsonResponse
	{
		// set instance(s) & variable(s)
		$this->getCommonAuthenticableUserService();

		// validate
		$user = $request->validated();
		$this->commonAuthenticableUserService->validateIfEmailExists($user['email']); 
		$this->commonAuthenticableUserService->validateIfEmailVerified($user['email']);

		// login
		if (!Auth::guard($this->getGuard())->attempt($user)) {
			$this->commonAuthenticableUserService->returnLoginFail();
		}
		$request->session()->regenerate();

		// return Json response
		$data = $this->commonService->getAuthenticatedUser();
		$viewModel = new AuthenticableUserDetailViewModel($data);
		return $this->response->successResponse(
			message: CommonResponseMessage::LOGIN_SUCCESS,
			data: $viewModel->data
		);
	}

	/**
	 * Handle a request to logout from an account
	 * 
	 * @param Request $request
	 * @return JsonResponse
	 */
	public function logout(Request $request): JsonResponse
	{
		// logout
		Auth::logout();
		$request->session()->invalidate();
		$request->session()->regenerateToken();

		// return Json response
		return $this->response->successResponse(
			message: CommonResponseMessage::LOGOUT_SUCCESS
		);
	}
}
