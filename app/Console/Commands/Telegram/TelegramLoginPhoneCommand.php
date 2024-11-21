<?php

namespace App\Console\Commands\Telegram;

use Illuminate\Console\Command;

class TelegramLoginPhoneCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'telegram:login-phone-command {session_name}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '[Telegram] Login With Phone';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        //
        $session_name = $this->argument('session_name');

    }
}
