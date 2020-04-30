<?php

namespace App\Listeners;

use App\Models\User;
use App\Notifications\UserVerifiedNotification;
use Illuminate\Auth\Events\Verified;

/**
 * Class UserVerifiedListener
 *
 * @package App\Listeners
 */
class UserVerifiedListener
{
    /**
     * Handle the event.
     *
     * @param  Verified  $event
     * @return void
     */
    public function handle(Verified $event)
    {
        User::getAdmin()->notify(new UserVerifiedNotification($event->user));
    }
}
