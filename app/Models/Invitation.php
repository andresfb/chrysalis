<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Str;

class Invitation extends Model
{
    use SoftDeletes;
    use Notifiable;

    protected $fillable = [
        'name',
        'email',
        'token',
        'request_ip',
        'agent',
        'registered_at',
        'expires_at',
    ];

    protected $casts = [
        'registered_at' => 'datetime',
        'expires_at' => 'datetime',
    ];

    protected function price(): Attribute
    {
        return Attribute::make(
            get: static fn ($value) => $value / 100,
        );
    }

    public function generateToken(): void
    {
        $this->token = substr(hash('sha256', Str::random(20).$this->email.time()), 0, 40);
        $this->expires_at = now()->addHours(config('invitation.expires_hours'));
    }

    public function routeNotificationForSlack(Notification $notification): string
    {
        return config('invitation.slack_webhook_url');
    }
}
