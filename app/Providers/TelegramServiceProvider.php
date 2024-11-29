<?php

namespace App\Providers;

use App\Services\Telegram\Bot\TelegramBotSessionService;
use Illuminate\Support\ServiceProvider;

class TelegramServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->singleton('telegram_bot_session', function ($app) {
            return new TelegramBotSessionService();
        });
    }
}
