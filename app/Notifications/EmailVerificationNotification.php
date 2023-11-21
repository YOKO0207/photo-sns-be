<?php

namespace App\Notifications;

use Illuminate\Auth\Notifications\VerifyEmail;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Carbon;

class EmailVerificationNotification extends VerifyEmail
{
	/**
	 * To use different route for each model, provide the route name ex) 'user'
	 */
	protected $routeName;

	public function __construct(string $routeName)
	{
		$this->routeName = $routeName;
	}

	
	/**
	 * Get the notification's delivery channels.
	 *
	 * @param mixed $notifiable
	 * @return array
	 */
	public function via($notifiable)
	{
		return ['mail'];
	}

	/**
	 * Get the verification URL for the given notifiable.
	 */
	protected function verificationUrl($notifiable)
	{
		return URL::temporarySignedRoute(
			'user.verification.verify',
			Carbon::now()->addMinutes(config('auth.email_verification_expire', 60)),
			[
				'id' => $notifiable->getKey(),
				'hash' => sha1($notifiable->getEmailForVerification()),
			]
		);
	}

	/**
	 * Get the mail representation of the notification.
	 *
	 * @param mixed $notifiable
	 * @return MailMessage
	 */
	public function toMail($notifiable)
	{
		$prefix = config('app.frontend_url') . '/' . $this->routeName . '/email-verification?url=';
		$verificationUrl = $this->verificationUrl($notifiable);

		return (new MailMessage)
			->subject(__('email-verification-subject'))
			->greeting(__('email-greeting', ['name' => $notifiable->name, "app_name" => config('app.name')]))
			->line(__('email-verification-click-link'))
			->action(__('email-verification-verify-email'), $prefix . urlencode($verificationUrl))
			->line(__('email-verification-ignore-email'))
			->line(__('email-verification-expire-note', ['count' => config('auth.email_verification_expire', 60) / (60 * 24)]))
			->line(__('email-no-reply'));
	}

	/**
	 * Get the array representation of the notification.
	 *
	 * @param mixed $notifiable
	 * @return array
	 */
	public function toArray($notifiable)
	{
		return [
			//
		];
	}
}
