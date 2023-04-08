<?php

namespace App\Providers;

use Illuminate\Auth\Events\Verified;
use Illuminate\Auth\Events\Registered;
use App\Listeners\User\UserVerifiedListener;
use App\Listeners\Project\ProjectSavingListener;
use App\Events\Project\ProjectSavingEvent;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

/**
 * Class EventServiceProvider
 *
 * @package App\Providers
 */
class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],

        Verified::class => [
            UserVerifiedListener::class
        ],

        ProjectSavingEvent::class => [
            ProjectSavingListener::class
        ],
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();

        //
    }
}
