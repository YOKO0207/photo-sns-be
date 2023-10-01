<?php

namespace App\Models\Contracts;

use Illuminate\Contracts\Auth\MustVerifyEmail;

interface AuthenticableUser extends MustVerifyEmail
{
	/**
	 * Send the email verification.
	 * 
	 * @param void
	 * @return void
	 */
	public function sendEmailVerificationNotification(): void;

	/**
	 * Send the email verification when updating email.
	 * 
	 * @param void
	 * @return void
	 */
	public function sendEmailUpdateVerificationNotification(): void;

	/**
	 * Use new_pending_email if it is set, otherwise use email.
	 * 
	 * @param $notication
	 * @return string
	 */
	public function routeNotificationForMail($notification): string;

	/**
	 * Use new_pending_email if it is set, otherwise use email.
	 * 
	 * @param void
	 * @return string
	 */
	public function getEmailForVerification(): string;

	/**
	 * Send a password reset notification.
	 * 
	 * @param string $token
	 * @return void
	 */
	public function sendPasswordResetNotification($token): void;
}