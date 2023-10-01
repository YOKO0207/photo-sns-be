<?php

namespace App\Notifications;

use Illuminate\Auth\Notifications\ResetPassword;

class PasswordResetNotification extends ResetPassword
{
	/**
	 * To use different route for each model, provide the route name ex) 'user'
	 */
	protected $routeName;
	/**
     * Create a new notification instance.
     */
    public function __construct(string $token, string $routeName)
    {
		parent::__construct($token);
		$this->routeName = $routeName;
    }

	/**
	 * Get the reset URL for the given notifiable.
	 *
	 * @param  mixed  $notifiable
	 * @return string
	 */
	protected function resetUrl($notifiable)
	{
		if (static::$createUrlCallback) {
			return call_user_func(static::$createUrlCallback, $notifiable, $this->token);
		}

		return config('app.frontend_url') . '/' . $this->routeName . '/password-reset?token=' . $this->token . '&email=' . $notifiable->getEmailForPasswordReset();
	}
}
