<?php

namespace App\Http\Controllers\Telegram\TelegramAPI;

use App\Http\Controllers\Controller;
use App\Services\Telegram\API\TelegramSessionService;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class TelegramAuthController extends Controller
{
    protected TelegramSessionService $telegramService;

    public function __construct(TelegramSessionService $telegramService)
    {
        $this->telegramService = $telegramService;
    }

    /**
     * Generate QR code for Telegram login
     */
    public function generateQrCode(): JsonResponse
    {
        try {
            $qrCode = $this->telegramService->get();

            return response()->json(['qr_code' => $qrCode]);
        } catch (Exception $e) {
            return response()->json(['error' => 'Failed to generate QR code'], 500);
        }
    }

    /**
     * Initiate phone number login
     */
    public function phoneLogin(Request $request): JsonResponse
    {
        $request->validate([
            'phone' => 'required|string'
        ]);

        try {
            $phoneNumber = $request->input('phone');
            $sentCode = $this->telegramService->sendCode($phoneNumber);

            // Store phone_code_hash in session for verification
            session(['phone_code_hash' => $sentCode->phone_code_hash]);

            return response()->json([
                'success' => true,
                'message' => 'Verification code sent'
            ]);
        } catch (Exception $e) {
            Log::error('Phone login failed: ' . $e->getMessage());
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    /**
     * Verify the code sent to phone
     */
    public function verifyCode(Request $request): JsonResponse
    {
        $request->validate([
            'code' => 'required|string',
            'phone' => 'required|string'
        ]);

        try {
            $phone = $request->input('phone');
            $code = $request->input('code');
            $phoneCodeHash = session('phone_code_hash');

            $result = $this->telegramService->verifyCode(
                $phone,
                $code,
                $phoneCodeHash
            );

            if ($result['_'] === 'auth.authorization') {
                return response()->json(['success' => true]);
            }

            // If 2FA is required
            if ($result['_'] === 'account.password') {
                return response()->json([
                    'requires_password' => true,
                    'message' => '2FA password required'
                ]);
            }

            return response()->json(['error' => 'Unknown response'], 400);
        } catch (Exception $e) {
            Log::error('Code verification failed: ' . $e->getMessage());
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    /**
     * Verify 2FA password if enabled
     */
    public function verifyPassword(Request $request): JsonResponse
    {
        $request->validate([
            'password' => 'required|string'
        ]);

        try {
            $password = $request->input('password');
            $result = $this->telegramService->complete2FALogin($password);

            return response()->json(['success' => true]);
        } catch (Exception $e) {
            Log::error('2FA verification failed: ' . $e->getMessage());
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    /**
     * Check current authentication status
     */
    public function checkAuthStatus(): JsonResponse
    {
        try {
            $status = $this->telegramService->getAuthStatus();
            return response()->json(['status' => $status]);
        } catch (Exception $e) {
            Log::error('Auth status check failed: ' . $e->getMessage());
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    /**
     * Logout from Telegram session
     */
    public function logout(): JsonResponse
    {
        try {
            $this->telegramService->logout();
            return response()->json(['success' => true]);
        } catch (Exception $e) {
            Log::error('Logout failed: ' . $e->getMessage());
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
