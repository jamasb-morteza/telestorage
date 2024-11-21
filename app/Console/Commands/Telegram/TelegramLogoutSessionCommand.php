<?php

namespace App\Console\Commands\Telegram;

use App\Services\Telegram\TelegramSessionService;
use danog\MadelineProto\API;
use danog\MadelineProto\Settings;
use Illuminate\Console\Command;

use function Laravel\Prompts\select;
use function Laravel\Prompts\info;
use function Laravel\Prompts\text;

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

    protected TelegramSessionService|null $telegram_service = null;

    public function handle()
    {
        //
        $session_name = $this->argument('session_name');
        $this->telegram_service = TelegramSessionService::getInstance($session_name);
        $this->logout();

    }


    protected function logout(): void
    {
        $logout = $this->telegram_service->logout();
        dump($logout);
    }


}
