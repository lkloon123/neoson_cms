<?php

namespace App\Listeners;

use Carbon\Carbon;
use Illuminate\Auth\Events\Login;
use Illuminate\Auth\Events\Logout;

class UserEventSubscriber
{
    /**
     * @param Login $event
     */
    public function onUserLogin(Login $event)
    {
        $event->user->update([
            'last_login_at' => Carbon::now(),
            'last_login_ip' => \Request::getClientIp()
        ]);
    }

    public function onUserLogout(Logout $event)
    {
        $event->user->update([
            'last_logout_at' => Carbon::now()
        ]);
    }

    /**
     * Handle the event.
     *
     * @param \Illuminate\Events\Dispatcher $event
     * @return void
     */
    public function subscribe($event)
    {
        $event->listen(
            Login::class,
            'App\Listeners\UserEventSubscriber@onUserLogin'
        );

        $event->listen(
            Logout::class,
            'App\Listeners\UserEventSubscriber@onUserLogout'
        );
    }
}
