<?php

namespace App\Listeners;

use App\Events\ServerInformed;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class ServerInformationNotification implements ShouldQueue
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
     * @param  ServerInformed  $event
     * @return void
     */
    public function handle(ServerInformed $event)
    {
        //
    }
}
