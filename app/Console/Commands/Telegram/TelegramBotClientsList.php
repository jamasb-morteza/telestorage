<?php

namespace App\Console\Commands\Telegram;

use App\Models\TelegramClient;
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
        foreach ($madelineProto->getDialogIds() as $dialog_id) {
            $client_info = $this->addToClientsDB($madelineProto->getInfo($dialog_id));
            dump($client_info->only([
                'telegram_user_id',
                'telegram_username',
                'type',
            ]));
        }
    }


    protected function addToClientsDB(array $client_info): TelegramClient
    {

        dump($client_info['User']);
        return TelegramClient::firstOrCreate(
            [
                'telegram_user_id' => $client_info['user_id'],
            ],
            [
                'telegram_user_id' => $client_info['user_id'] ?? null,
                'telegram_bot_user_id' => $client_info['bot_api_id'] ?? null,
                'telegram_username' => $client_info['User']['username'] ?? null,
                'type' => $client_info['type'] ?? null,
                'client_details' => isset($client_info['User']) ? json_encode($client_info['User']) : null,
            ]
        );
    }

}
