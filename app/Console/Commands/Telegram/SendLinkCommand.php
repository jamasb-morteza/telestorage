<?php

namespace App\Console\Commands\Telegram;

use App\Services\Telegram\Bot\TelegramBotSessionService;
use Illuminate\Console\Command;

class SendLinkCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'telegram:link-send {mobile_number}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '[Telegram] Send Link Command';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        //
        $mobile_number = $this->argument('mobile_number');
        $madelineProto = app(TelegramBotSessionService::class)->getMadelineAPI();
        $user_uuid = uniqid(); // Generate a unique user UUID
        $verification_code = rand(100000, 999999); // Generate a random 6-digit verification code
        $madelineProto->sendMessage($mobile_number, "Your verification code is: {$verification_code}");



        // todo
    }
}
