<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
		$this->app->when(\App\Services\UserAuthService::class)
		->needs(\App\Repositories\Contracts\AuthenticableUserRepositoryInterface::class)
		->give(\App\Repositories\Eloquent\UserRepository::class);

		$this->app->when(\App\Services\UserPasswordResetService::class)
		->needs(\App\Repositories\Contracts\AuthenticableUserRepositoryInterface::class)
		->give(\App\Repositories\Eloquent\UserRepository::class);

		$this->app->when(\App\Services\UserAccountService::class)
		->needs(\App\Repositories\Contracts\AuthenticableUserRepositoryInterface::class)
		->give(\App\Repositories\Eloquent\UserRepository::class);

		$this->app->when(\App\Services\UserEmailVerificationService::class)
		->needs(\App\Repositories\Contracts\AuthenticableUserRepositoryInterface::class)
		->give(\App\Repositories\Eloquent\UserRepository::class);
    }
	
	/**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
