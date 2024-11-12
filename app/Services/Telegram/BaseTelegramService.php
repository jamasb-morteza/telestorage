<?php

namespace App\Services\Telegram;

use danog\MadelineProto\EventHandler;

abstract class BaseTelegramService extends EventHandler
{
    public function getReportPeers()
    {
        return [];
    }

    public static function startAndLoop($session, $settings)
    {
        $handler = new self($session, $settings);
        $handler->loop();
    }
}