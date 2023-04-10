<?php

namespace App\Models;

use App\Notifications\ResetPassword;
use App\Notifications\VerifyEmail as AppVerifyEmail;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens;
    use HasFactory;
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
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
    ];

    /**
     * Overridden from the MustVerifyEmail train to call the custom App\Notifications\VerifyEmail
     * class where we override Illuminate\Auth\Notifications\VerifyEmail::verificationUrl()
     * to use the tenant.verification.verify route instead of the default verification.verify route.
     */
    public function sendEmailVerificationNotification(): void
    {
        $this->notify(new AppVerifyEmail);
    }

    /**
     * Overridden from the CanResetPassword train to call the custom App\Notifications\ResetPassword
     * class where we override Illuminate\Auth\Notifications\ResetPassword::resetUrl()
     * to use the tenant.password.reset route instead of the default password.reset route.
     */
    public function sendPasswordResetNotification($token): void
    {
        $this->notify(new ResetPassword($token));
    }
}
