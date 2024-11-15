<?php

namespace App\Services\Telegram;

use danog\MadelineProto\API;
use danog\MadelineProto\Exception;
use danog\MadelineProto\Settings;
use danog\MadelineProto\Settings\Logger;
use Illuminate\Support\Facades\Log;


class TelegramSessionService
{
    private API $madelineProto;

    public function __construct(string $session = 'session.madeline')
    {
        try {
            $app_info = (new \danog\MadelineProto\Settings\AppInfo)
                ->setApiId(config('services.telegram.api_id'))
                ->setApiHash(config('services.telegram.api_hash'));
            $logger = new Logger();
            $settings = new Settings();
            $settings->setAppInfo($app_info);
            $settings->setLogger($logger);
            $this->madelineProto = new API($session, $settings);
        } catch (Exception $e) {
            Log::error('[Telegram] Failed to construct TelegramSession: ' . $e->getMessage());
            throw $e;
        }
        $this->madelineProto->start();
    }

    /**
     * Send verification code to phone number
     */
    public function sendCode(string $phoneNumber): array
    {
        try {
            return $this->madelineProto->phoneLogin($phoneNumber);
        } catch (Exception $e) {
            Log::error('[Telegram] Failed to send code: ' . $e->getMessage());
            throw $e;
        }
    }

    /**
     * Complete phone login process
     */
    public function completePhoneLogin(string $phone, string $code, string $phoneCodeHash): array
    {
        try {
            return $this->madelineProto->completePhoneLogin($code, $phoneCodeHash);
        } catch (Exception $e) {
            Log::error('[Telegram] Failed to complete phone login: ' . $e->getMessage());
            throw $e;
        }
    }

    /**
     * Complete 2FA login with password
     */
    public function complete2FALogin(string $password): array
    {
        try {
            return $this->madelineProto->complete2faLogin($password);
        } catch (Exception $e) {
            Log::error('[Telegram] Failed to complete 2FA: ' . $e->getMessage());
            throw $e;
        }
    }

    /**
     * Start QR code login process
     */
    public function startQRLogin(): ?string
    {
        try {

            $qrLogin = $this->madelineProto->qrLogin();
            return $qrLogin?->token ?? null;
        } catch (Exception $e) {
            Log::error('[Telegram] Failed to generate QR code: ' . $e->getMessage());
            throw $e;
        }
    }

    /**
     * Check QR code login status
     */
    public function checkQrStatus(): array
    {
        try {
            return $this->madelineProto->checkQrLogin();
        } catch (Exception $e) {
            Log::error('[Telegram] Failed to check QR login status: ' . $e->getMessage());
            throw $e;
        }
    }

    /**
     * Get current authentication status
     */
    public function getAuthStatus(): array
    {
        try {
            $self = $this->madelineProto->getSelf();
            return [
                'logged_in' => $self !== null,
                'user' => $self
            ];
        } catch (Exception $e) {
            return [
                'logged_in' => false,
                'error' => $e->getMessage()
            ];
        }
    }

    /**
     * Logout from current session
     */
    public function logout(): bool
    {
        try {
            $this->madelineProto->logout();
            return true;
        } catch (Exception $e) {
            Log::error('[Telegram] Failed to logout: ' . $e->getMessage());
            throw $e;
        }
    }
}

