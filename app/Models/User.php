<?php

namespace App\Models;

use App\Models\Contracts\AuthenticableUser;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use App\Notifications\{
	EmailVerificationNotification, 
	EmailUpdateVerificationNotification, 
	PasswordResetNotification};

class User extends Authenticatable implements AuthenticableUser
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
		'new_pending_email',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

	/**
	 * Send the email verification.
	 * 
	 * @param void
	 * @return void
	 */
	public function sendEmailVerificationNotification(): void
	{
		$this->notify(new EmailVerificationNotification('user'));
	}

	/**
	 * Send the email verification when updating email.
	 * 
	 * @param void
	 * @return void
	 */
	public function sendEmailUpdateVerificationNotification(): void
	{
		$this->notify(new EmailUpdateVerificationNotification('user'));
	}

	/**
	 * Use new_pending_email if it is set, otherwise use email.
	 * 
	 * @param $notication
	 * @return string
	 */
	public function routeNotificationForMail($notification): string
	{
		return $this->new_pending_email ?? $this->email;
	}

	/**
	 * Use new_pending_email if it is set, otherwise use email.
	 * 
	 * @param void
	 * @return string
	 */
	public function getEmailForVerification(): string
	{
		return $this->new_pending_email ?? $this->email;
	}

	/**
	 * Send a password reset notification.
	 * 
	 * @param string $token
	 * @return void
	 */
	public function sendPasswordResetNotification($token): void
	{
		$this->notify(new PasswordResetNotification($token, 'user'));
	}
}
