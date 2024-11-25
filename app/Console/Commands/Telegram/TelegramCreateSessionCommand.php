<?php

namespace App\Console\Commands\Telegram;

use App\Services\Telegram\API\TelegramSessionService;
use Illuminate\Console\Command;
use function Laravel\Prompts\info;
use function Laravel\Prompts\text;

class TelegramCreateSessionCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'telegram:session-create {session_name}';

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
        $this->telegram_service = TelegramSessionService::getInstance($session_name);
        $session_status = $this->telegram_service->getSessionStatus();
        dump(compact('session_status'));
    }


    protected function loginWithPhone(): void
    {
        $phone_number = $name = text(
            label: 'Enter Phone number',
            placeholder: 'eg: +1 226 883 3333',
            required: 'Your name is required.',
            hint: 'Verification Code will sent to this telegram account!',
        );
        $this->telegram_service->loginWithPhone($phone_number);
        info("Verification Code has been sent");
        $verification_code = text(
            label: 'Enter Verification Code',
            required: 'Your name is required.',
            hint: 'Verification Code from your telegram',
        );
        $result = $this->telegram_service->verifyCode($verification_code);
        dump($result);
    }


}
