<?php

namespace App\Listeners\User;

use App\Models\User;
use Illuminate\Auth\Events\Verified;
use App\Notifications\User\UserVerifiedNotification;

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
