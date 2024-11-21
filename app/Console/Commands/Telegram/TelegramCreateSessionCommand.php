<?php

namespace App\Console\Commands\Telegram;

use App\Services\Telegram\TelegramSessionService;
use Illuminate\Console\Command;

class TelegramCreateSessionCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'telegram:create-session-command {session_name}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '[Telegram] Create Session Command';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        //
        $session_name = $this->argument('session_name');
        $service = new TelegramSessionService($session_name);
//        $service->loginWithPhone('+1');
        $login_type = $this->choice("Login Type", ['Login Using Verification Code', 'Login Using Verification QRCode'], 'Login Using Verification Code');
        dd($login_type);
    }
}
