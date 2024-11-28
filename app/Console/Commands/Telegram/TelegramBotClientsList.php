<?php

namespace App\Console\Commands\Telegram;

use App\Services\Telegram\API\TelegramSessionService;
use App\Services\Telegram\Bot\TelegramBotSessionService;
use Illuminate\Console\Command;
use function Laravel\Prompts\info;
use function Laravel\Prompts\text;
use function Laravel\Prompts\outro;

class TelegramBotClientsList extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'telegram:client-list';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '[Telegram] Create Session Command';

    /**
     * Execute the console command.
     */

    protected \App\Services\Telegram\API\TelegramSessionService|null $telegram_service = null;

    public function handle()
    {
        //
        $madelineProto = app(TelegramBotSessionService::class)->getMadelineAPI();
        outro("Client list:");
        $dialogs = $madelineProto->getSelf();
        dd($dialogs);
    }


}
