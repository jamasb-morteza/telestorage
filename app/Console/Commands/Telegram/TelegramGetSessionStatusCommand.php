<?php

namespace App\Console\Commands\Telegram;

use App\Services\Telegram\API\TelegramSessionService;
use App\Services\Telegram\Bot\TelegramBotSessionService;
use Illuminate\Console\Command;

class TelegramGetSessionStatusCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'telegram:session-status';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '[Telegram] Get Session Status';

    protected $telegram_service = null;

    /**
     * Execute the console command.
     */
    public function handle()
    {

        dump(app(TelegramBotSessionService::class)->getSessionStatus());
    }
}
