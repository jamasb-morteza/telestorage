<?php

namespace App\Console\Commands\Telegram;

use App\Services\Telegram\API\TelegramSessionService;
use Illuminate\Console\Command;

class TelegramGetSessionStatusCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'telegram:session-status {--session_name}';

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
        //
        $session_name = $this->argument('session_name');
        $this->telegram_service = TelegramSessionService::getInstance($session_name);
        $this->telegram_service->getSessionStatus();
    }
}
