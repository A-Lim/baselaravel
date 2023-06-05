<?php

namespace App\Listeners;

use Illuminate\Auth\Events\Registered;

class SendEmailVerificationEmail {

    public function __construct() {
    }

    public function handle(Registered $event) {
        $user = $event->user;
        $user->sendEmailVerificationNotification();
    }
}
