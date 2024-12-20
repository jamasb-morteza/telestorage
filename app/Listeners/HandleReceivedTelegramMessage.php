<?php

namespace App\Listeners;

use App\Events\TelegramMessageReceived;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class HandleReceivedTelegramMessage
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
    public function handle(TelegramMessageReceived $event): void
    {
        //

    }
}
