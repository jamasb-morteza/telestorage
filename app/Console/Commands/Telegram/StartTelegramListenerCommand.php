<?php

namespace App\Console\Commands\Telegram;

use App\Services\Telegram\Bot\TelegramBotSessionService;
use Illuminate\Console\Command;

class StartTelegramListenerCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'telegram:listen';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '[Telegram] Start the Telegram event listener using MadelineProto';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        //
        $madeline_proto = app(TelegramBotSessionService::class)->getAPI();
        $event_handler = new TelegramEventHandler($madeline_proto);
    }
}
