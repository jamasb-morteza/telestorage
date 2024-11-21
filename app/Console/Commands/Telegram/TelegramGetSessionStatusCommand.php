<?php

namespace App\Console\Commands\Telegram;

use Illuminate\Console\Command;

class TelegramGetSessionStatusCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'telegram:get-session-status-command {--session_name}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '[Telegram] Get Session Status';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        //
    }
}
