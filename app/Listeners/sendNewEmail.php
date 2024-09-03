<?php

namespace App\Listeners;

use App\Events\NewEmail;
use App\Mail\sendEmail;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Mail;

class sendNewEmail  implements ShouldQueue
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(NewEmail $event): void
    {

        Mail::to($event->user->email)->send(new sendEmail($event->user));
    }
}
