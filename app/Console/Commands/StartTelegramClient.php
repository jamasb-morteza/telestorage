<?php

namespace App\Console\Commands;

use App\Services\TelegramService;
use Illuminate\Console\Command;
use danog\MadelineProto\Settings;
use danog\MadelineProto\Settings\AppInfo;
use danog\MadelineProto\Logger;

class StartTelegramClient extends Command
{
    protected $signature = 'telegram:start';
    protected $description = 'Start the Telegram client';

    public function handle()
    {
        $settings = (new AppInfo)
            ->setApiId(config('services.telegram.api_id'))
            ->setApiHash(config('services.telegram.api_hash'));

        $settings->getLogger()->setLevel(Logger::LEVEL_ULTRA_VERBOSE);

        TelegramService::startAndLoop(
            storage_path('app/madeline/session.madeline'),
            $settings
        );
    }
}