<?php

namespace App\Listeners\Auth;

use App\Events\Auth\UserRequestedActivationEmail;
use App\Mail\Auth\ActivationEmail;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Mail;

class SendActivationEmail
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  UserRequestedActivationEmail  $event
     * @return void
     */
    public function handle(UserRequestedActivationEmail $event)
    {
        // If user is already active, don't need to send email
        if($event->user->active) {
            return;
        }

        Mail::to($event->user->email)->queue(new ActivationEmail($event->user));
    }
}
