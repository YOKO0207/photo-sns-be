<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    // query class bind
	protected $queries = [
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
		->needs(\App\Repositories\Contracts\UserRepositoryInterface::class)
		->give(\App\Repositories\Eloquent\UserRepository::class);

		$this->app->when(\App\Services\UserPasswordResetService::class)
		->needs(\App\Repositories\Contracts\UserRepositoryInterface::class)
		->give(\App\Repositories\Eloquent\UserRepository::class);

		$this->app->when(\App\Services\UserAccountService::class)
		->needs(\App\Repositories\Contracts\UserRepositoryInterface::class)
		->give(\App\Repositories\Eloquent\UserRepository::class);

		$this->app->when(\App\Services\UserEmailVerificationService::class)
		->needs(\App\Repositories\Contracts\UserRepositoryInterface::class)
		->give(\App\Repositories\Eloquent\UserRepository::class);

		// post bindings
		$this->app->when(\App\Services\PostService::class)
		->needs(\App\Repositories\Contracts\ListableCrudRepositoryInterface::class)
		->give(\App\Repositories\Eloquent\PostRepository::class);

		$this->app->when(\App\Repositories\Eloquent\PostRepository::class)
		->needs(\App\Queries\Contracts\ListQueryInterface::class)
		->give(\App\Queries\Eloquent\PostQuery::class);

		// post thread bindings
		$this->app->when(\App\Repositories\Eloquent\PostThreadRepository::class)
		->needs(\App\Queries\Contracts\ScopedListQueryInterface::class)
		->give(\App\Queries\Eloquent\PostThreadQuery::class);

		$this->app->when(\App\Services\PostThreadService::class)
		->needs(\App\Repositories\Contracts\ScopedListableCrudRepositoryInterface::class)
		->give(\App\Repositories\Eloquent\PostThreadRepository::class);

		// post thread comment bindings
		$this->app->when(\App\Repositories\Eloquent\PostThreadCommentRepository::class)
		->needs(\App\Queries\Contracts\ScopedListQueryInterface::class)
		->give(\App\Queries\Eloquent\PostThreadCommentQuery::class);

		$this->app->when(\App\Services\PostThreadCommentService::class)
		->needs(\App\Repositories\Contracts\ScopedListableCrudRepositoryInterface::class)
		->give(\App\Repositories\Eloquent\PostThreadCommentRepository::class);
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
