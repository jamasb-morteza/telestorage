<?php

namespace App\Services\Telegram\API;

use Amp\CancelledException;
use Amp\TimeoutCancellation;
use danog\MadelineProto\API as MadelineAPI;
use danog\MadelineProto\Exception;
use danog\MadelineProto\Settings;
use danog\MadelineProto\Settings\AppInfo;
use Illuminate\Support\Facades\Log;
use function PHPUnit\Framework\throwException;


class TelegramSessionService
{
    private MadelineAPI $madelineProtoAPI;
    private string $telegram_session_name;
    protected static self|null $madelineProtoAPIInstance = null;

    public function __construct(string $session = 'session.madeline')
    {
        $this->telegram_session_name = $session;
        try {
            $app_info = (new AppInfo)
                ->setApiId(config('services.telegram.api_id'))
                ->setApiHash(config('services.telegram.api_hash'));

            $settings = new Settings();

            $settings->setAppInfo($app_info);
            $session_db_settings = (new Settings\Database\Mysql())
                ->setUri('tcp://' . config('database.connections.mariadb_sessions.host'))
                ->setDatabase(config('database.connections.mariadb_sessions.database'))
                ->setUsername(config('database.connections.mariadb_sessions.username'))
                ->setPassword(config('database.connections.mariadb_sessions.password'));

            $settings->setDb($session_db_settings);
            $this->madelineProtoAPI = new MadelineAPI($this->telegram_session_name, $settings);

        } catch (Exception $exception) {
            Log::error('[Telegram] Failed to construct TelegramSession', ['session' => $this->telegram_session_name, 'exception' => $exception->getMessage()]);
            throwException($exception);
        }
    }

    public function loginWithPhone(string $phone_number): array
    {

        // Send OTP
        try {
            $this->madelineProtoAPI->phoneLogin($phone_number);
        } catch (\Exception $exception) {
            Log::error('[Telegram] Fail to send otp', ['session' => $this->telegram_session_name, 'exception' => $exception->getMessage()]);
            throwException($exception);
        }
        Log::info('[Telegram] OTP sent successfully', ['session' => $this->telegram_session_name]);
        return ['success' => true, 'message' => 'OTP sent to your phone.'];
    }

    public function verifyCode(string $otp_code): array
    {

        try {
            $this->madelineProtoAPI->completePhoneLogin($otp_code);
            $this->madelineProtoAPI = new MadelineAPI($this->telegram_session_name);
        } catch (\Exception $exception) {
            Log::error('[Telegram] Failed to complete login', ['exception' => $exception->getMessage()]);
            throwException($exception);
        }
        Log::info('[Telegram] Logged in successfully', ['session' => $this->telegram_session_name]);
        // Verify OTP
        return ['success' => true, 'message' => 'Logged in successfully.'];
    }

    public function generateQrCode(null|float $wait_qr_login = null): array
    {
        // Generate a QR code for Telegram session login
        $qr_code = null;
        try {
            $qr_code = $this->madelineProtoAPI->qrLogin();
            if ($wait_qr_login) {
                $qr_code = $qr_code?->waitForLoginOrQrCodeExpiration(new TimeoutCancellation(5.0));
            }
        } catch (CancelledException) {
            $qr_code = $this->madelineProtoAPI->qrLogin();
        } catch (\Exception $exception) {
            Log::error('[Telegram] QR Login failed', ['session' => $this->telegram_session_name, 'exception' => $exception->getMessage()]);
            throwException($exception);
        }

        if ($qr_code) {
            return [
                'success' => true,
                'logged_in' => false,
                'svg' => $qr_code->getQRSvg(400, 2)
            ];
        }
        return [
            'logged_in' => true,
            'needs_2fa' => $this->madelineProtoAPI->getAuthorization() === MadelineAPI::WAITING_PASSWORD
        ];
    }

    public function getSessionStatus(): array
    {
        $result = [
            'success' => true,
            'logged_in' => false,
            'status_text' => null,
            'status_code' => null
        ];
        try {
            $status = $this->madelineProtoAPI->getAuthorization();
            $result['status_code'] = $status;
            $result['logged_in'] = $status === MadelineAPI::LOGGED_IN;
            $result['status_text'] = match ($status) {
                MadelineAPI::NOT_LOGGED_IN => 'Not Logged in',
                MadelineAPI::WAITING_CODE => 'Waiting for Code',
                MadelineAPI::WAITING_SIGNUP => 'Waiting for signup',
                MadelineAPI::WAITING_PASSWORD => 'Waiting for password',
                MadelineAPI::LOGGED_IN => 'Logged in',
                MadelineAPI::LOGGED_OUT => 'Logged out',
            };
        } catch (\Exception $exception) {
            Log::error('[Telegram] Failed to get authorization status', [
                'session' => $this->telegram_session_name,
                'exception' => $exception->getMessage()
            ]);
            throwException($exception);
        }
        return $result;
    }

    public function sessionInfo()
    {
        $full_self = $this->madelineProtoAPI->getSelf();
        return $full_self;
    }

    public function logout()
    {

        try {
            $this->madelineProtoAPI->logout();
        } catch (\Exception $exception) {
            Log::error('[Telegram] Error logging out ', [
                'session' => $this->telegram_session_name,
                'exception' => $exception->getMessage()
            ]);
            throwException($exception);
        }
        return ['success' => true];
    }

    public function getMadelineAPI(): MadelineAPI
    {
        return $this->madelineProtoAPI;
    }

    public static function getInstance($session_name)
    {
        if (!self::$madelineProtoAPIInstance) {
            self::$madelineProtoAPIInstance = new self($session_name);
        }
        return self::$madelineProtoAPIInstance;
    }
}

