<?php

namespace App\Services\Telegram\Bot;

use App\Models\TelegramSession;
use danog\MadelineProto\API as MadelineAPI;
use danog\MadelineProto\Settings;
use Illuminate\Support\Facades\Log;
use danog\MadelineProto\Logger;
use danog\MadelineProto\Settings\Logger as LoggerSettings;
use function PHPUnit\Framework\throwException;

class TelegramBotSessionService
{
    private string $telegram_session_name;
    private TelegramSession $telegramSession;
    private MadelineAPI $madelineProtoAPI;

    public function __construct(string|null $session_name = 'telegram_bot_session')
    {
        if (!$session_name) {
            $session_name = config('services.telegram.bot_default_session_name');
        }
        $this->telegram_session_name = $session_name;
        $this->initializeSession();
    }

    private function initializeSession()
    {
        try {
            // Try to find existing session
            $this->telegramSession = TelegramSession::firstOrNew([
                'session_name' => $this->telegram_session_name
            ]);

            // Check if existing session is valid
            if ($this->telegramSession->exists && $this->telegramSession->isValid()) {
                // Load existing session
                $this->madelineProtoAPI = new MadelineAPI($this->telegram_session_name);
            } else {
                // Create new session
                $this->createNewSession();
            }
        } catch (\Exception $e) {
            Log::error('[Telegram] session initialization error: ' . $e->getMessage());
            $this->createNewSession();
        }
    }

    private function createNewSession()
    {
        Log::info('[Telegram] Initializing new session', ['session' => $this->telegram_session_name]);
        // Prepare settings
        $settings = new Settings();

        $app_info = (new Settings\AppInfo())
            ->setApiId(config('services.telegram.api_id'))
            ->setApiHash(config('services.telegram.api_hash'));

        $session_db_settings = (new Settings\Database\Mysql())
            ->setUri('tcp://' . config('database.connections.mariadb_sessions.host'))
            ->setDatabase(config('database.connections.mariadb_sessions.database'))
            ->setUsername(config('database.connections.mariadb_sessions.username'))
            ->setPassword(config('database.connections.mariadb_sessions.password'));

        $log_settings = (new LoggerSettings())
            ->setType(Logger::FILE_LOGGER)
            ->setExtra(storage_path('logs/madeline_proto.log'));
        $settings->setDb($session_db_settings);
        $settings->setAppInfo($app_info);
        $settings->setLogger($log_settings);
        // Initialize MadelineProto API
        try {
            $this->madelineProtoAPI = new MadelineAPI($this->telegram_session_name, $settings);
            Log::info('[Telegram] Session initialized successfully', ['session' => $this->telegram_session_name]);
        } catch (\Exception $exception) {
            Log::info('[Telegram] Failed to initialize new session', ['session' => $this->telegram_session_name, 'exception' => $exception->getMessage()]);
            throw $exception;
        }

        // Perform bot login
        $this->madelineProtoAPI->botLogin(config('services.telegram.bot_token'));

        // Remove settings after login
        $this->madelineProtoAPI->updateSettings(new Settings());

        // Update or create session record
        $this->updateSessionRecord();
    }

    private function updateSessionRecord()
    {
        try {
            $this->telegramSession->fill([
                'session_name' => $this->telegram_session_name,
                'bot_token' => config('services.telegram.bot_token'),
                'api_id' => config('services.telegram.api_id'),
                'api_hash' => config('services.telegram.api_hash'),
                'is_logged_in' => true,
                'expires_at' => now()->addDays(30),
                'additional_data' => [
                    'login_method' => 'bot',
                    'created_at' => now()->toDateTimeString()
                ]
            ]);

            $this->telegramSession->save();
        } catch (\Exception $exception) {
            Log::error('[Telegram] Failed to update session record: ' . $exception->getMessage(), ['session_name' => $this->telegram_session_name]);
            throw $exception;
        }
    }

    public function getAPI(): MadelineAPI
    {
        return $this->madelineProtoAPI;
    }

    public function getSessionModel(): TelegramSession
    {
        return $this->telegramSession;
    }

    /**
     * Manually refresh or reset the session
     */
    public function refreshSession()
    {
        $this->telegramSession->delete();
        $this->initializeSession();
    }
}
