<?php

namespace App\Listeners;

use Illuminate\Auth\Events\Login;

class UpdateLastLoginAt
{
    public function handle(Login $event): void
    {
        $user = $event->user;

        if ($user) {
            $user->last_login_at = now();
            $user->save();
        }
    }
}
