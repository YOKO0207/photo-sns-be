<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{
	PostController,
	UserAccountController,
	UserAuthController,
	UserEmailVerificationController,
	UserPasswordResetController
};

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

/*
|------------------------------------------------------------------------------
| User unauthenticated Routes
|------------------------------------------------------------------------------
|
| Here is where you can register guest routes for your application.
|
*/
Route::prefix('user')->as('user.')->group(function () {
	Route::get('/email-verification/{id}/{hash}', [UserEmailVerificationController::class, 'verify'])
		->middleware(['signed'])
		->name('verification.verify');
	Route::post('email-verification/resend', [UserEmailVerificationController::class, 'resend'])
		->middleware(['throttle:6,1'])->name('verification.resend');
	Route::get('/email/update/email-verification/{id}/{hash}', [UserEmailVerificationController::class, 'verifyUpdateEmail'])
		->middleware(['signed'])->name('email.update.verification.verify');

	// auth
	Route::post('/register', [UserAuthController::class, 'register']);
	Route::post('/login', [UserAuthController::class, 'login']);

	// password reset
	Route::post('password-forget', [UserPasswordResetController::class, 'sendPasswordResetLink'])->name('password.forget');
	Route::post('password-reset', [UserPasswordResetController::class, 'resetPassword'])->name('password.reset');
});
/*
|------------------------------------------------------------------------------
| User authenticated Routes
|------------------------------------------------------------------------------
|
| Here is where you can register user routes for your application.
|
*/
// authenticated routes
Route::prefix('user')->as('user.')->group(function () {
	Route::middleware('auth:user')->group(function () {
		// auth
		Route::post('/logout', [UserAuthController::class, 'logout']);

		Route::prefix('account')->as('account.')->group(function () {
			Route::put('/email', [UserAccountController::class, 'updateEmail'])->name('email.update');
			Route::put('/password', [UserAccountController::class, 'updatePassword'])->name('password.update');
			Route::put('/name', [UserAccountController::class, 'updateName'])->name('name.update'); // will probably refactor this to profile
			Route::delete('/user', [UserAccountController::class, 'destroy'])->name('destroy');
		});
	});
});
Route::middleware('auth:user')->group(function () {
	Route::resource('posts', PostController::class)
	->names([
		'store' => 'posts.store',
		'update' => 'posts.update',
		'destroy' => 'posts.destroy',
	])
	->only(['store', 'update', 'destroy']);
});
/*
|------------------------------------------------------------------------------
| Routes
|------------------------------------------------------------------------------
|
| Here is where you can register guest routes for your application.
|
*/
Route::resource('posts', PostController::class)
->names([
	'index' => 'posts.index',
	'show' => 'posts.show',
])
->only(['index', 'show']);