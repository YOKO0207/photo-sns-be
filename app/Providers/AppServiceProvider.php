<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    // query class bind
	protected $queries = [
		\App\Queries\Contracts\ListQueryInterface::class
		=> \App\Queries\Eloquent\PostQuery::class,
	];
	// repository class bind
	protected $repositories = [
		
	];
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

		$this->app->when(\App\Services\PostService::class)
		->needs(\App\Repositories\Contracts\ListableCrudRepositoryInterface::class)
		->give(\App\Repositories\Eloquent\PostRepository::class);
    }

	/**
	 * Bind Query classes
	 *
	 * @return void
	 */
	protected function bindQuery()
	{
		foreach ($this->queries as $abstract => $class) {
			$this->app->bind($abstract, $class);
		}
	}

	/**
	 * Bind Repository classes
	 *
	 * @return void
	 */
	protected function bindRepository()
	{
		foreach ($this->repositories as $abstract => $class) {
			$this->app->bind($abstract, $class);
		}
	}
	
	/**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
		$this->bindQuery();
		$this->bindRepository();
    }
}
