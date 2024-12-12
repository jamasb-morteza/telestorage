<?php

namespace App\Console\Commands\Telegram;

use App\Services\Telegram\Bot\TelegramBotSessionService;
use Illuminate\Console\Command;

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
    protected $description = '[Telegram] Get Telegram Bot clients list';

    /**
     * Execute the console command.
     */

    protected \App\Services\Telegram\API\TelegramSessionService|null $telegram_service = null;

    public function handle()
    {
        //
        $madelineProto = app(TelegramBotSessionService::class)->getAPI();
        $dialog_ids = $madelineProto->getDialogIds();
        dump($dialog_ids);
        // Process and display the chats
        foreach ($dialog_ids as $dialog_id) {

            dump($madelineProto->getInfo($dialog_id));
        }
    }


}
