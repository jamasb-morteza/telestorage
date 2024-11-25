<?php

namespace App\Services\Telegram\Bot;

use Amp\CancelledException;
use Amp\TimeoutCancellation;
use danog\MadelineProto\API as MadelineAPI;
use danog\MadelineProto\Exception;
use danog\MadelineProto\Settings;
use danog\MadelineProto\Settings\AppInfo;
use Illuminate\Support\Facades\Log;
use function PHPUnit\Framework\throwException;


class TelegramBotSessionService
{
    private MadelineAPI $madelineProtoAPI;
    private string $telegram_session_name;
    protected static self|null $madelineProtoAPIInstance = null;

    public function __construct(string $session = 'session.madeline')
    {
        $this->telegram_session_name = $session;
        Log::info('[Telegram] Bot Initializing', ['session' => $this->telegram_session_name]);
        try {
            $settings = new Settings();
            $session_db_settings = (new Settings\Database\Mysql())
                ->setUri('tcp://' . config('database.connections.mariadb_sessions.host'))
                ->setDatabase(config('database.connections.mariadb_sessions.database'))
                ->setUsername(config('database.connections.mariadb_sessions.username'))
                ->setPassword(config('database.connections.mariadb_sessions.password'));

            $settings->setDb($session_db_settings);
            $this->madelineProtoAPI = new MadelineAPI($this->telegram_session_name, $settings);
            $this->madelineProtoAPI->botLogin(config('services.telegram.bot_token'));
            $this->madelineProtoAPI->start();
        } catch (Exception $exception) {
            Log::error('[Telegram] Failed to construct TelegramSession', ['session' => $this->telegram_session_name, 'exception' => $exception->getMessage()]);
            throwException($exception);
        }
    }

    public function getMadelineAPI(): MadelineAPI
    {
        return $this->madelineProtoAPI;
    }
}

