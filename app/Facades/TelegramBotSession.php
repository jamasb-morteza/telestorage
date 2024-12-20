<?php

namespace App\Facades;

use Illuminate\Support\Facades\Facade;

class TelegramBotSession extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'telegram_bot_session';
    }
}
