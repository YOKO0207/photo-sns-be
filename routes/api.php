<?php

use App\Http\Controllers\UserAccountController;
use App\Http\Controllers\UserAuthController;
use App\Http\Controllers\UserEmailVerificationController;
use App\Http\Controllers\UserPasswordResetController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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