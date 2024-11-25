<?php

namespace App\Console\Commands\Telegram;

use Illuminate\Console\Command;

class TelegramLogoutSessionCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'telegram:session-logout {session_name}';

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
        $session_name = $this->argument('session_name');
        $this->telegram_service = \App\Services\Telegram\API\TelegramSessionService::getInstance($session_name);
        $this->logout();

    }


    protected function logout(): void
    {
        $logout = $this->telegram_service->logout();
        dump($logout);
    }


}
