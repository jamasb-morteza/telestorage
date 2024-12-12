<?php

namespace App\Console\Commands\Telegram;

use App\Services\Telegram\Bot\TelegramBotSessionService;
use Illuminate\Console\Command;

class TelegramSendMediaCommand extends Command
{
    //
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'telegram:send-media {--file=}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '[Telegram] Get Session Status';

    protected $telegram_service;


    /**
     * Execute the console command.
     */
    public function handle()
    {
        //
        $this->telegram_service = app(TelegramBotSessionService::class);
        $file = $this->argument('file');
        $madelineProto = $this->telegram_service->getAPI();
        $madelineProto->messages->sendMedia(
            peer: '@m.jamasb',
            media: [
                '_' => 'inputMediaUploadedDocument',
                'file' => [
                    'file' => $file,
                ]
            ]
        );
    }
}
