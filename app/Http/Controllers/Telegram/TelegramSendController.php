<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Services\Telegram\TelegramSendService;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Validator;

class TelegramSendController extends Controller
{
    private TelegramSendService $telegramService;

    public function __construct(TelegramSendService $telegramService)
    {
        $this->telegramService = $telegramService;
    }

    public  function sendMessage(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'peer_id' => 'required|string',
            'message' => 'required|string'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            $result =  $this->telegramService->sendMessage(
                $request->input('peer_id'),
                $request->input('message')
            );

            return response()->json([
                'success' => true,
                'data' => $result
            ]);
        } catch (\Throwable $e) {
            return response()->json([
                'success' => false,
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public  function sendImage(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'peer_id' => 'required|string',
            'image' => 'required|image|max:10240', // 10MB max
            'compress' => 'boolean'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            $result = await $this->telegramService->sendImage(
                $request->input('peer_id'),
                $request->file('image'),
                $request->boolean('compress', true)
            );

            return response()->json([
                'success' => true,
                'data' => $result
            ]);
        } catch (\Throwable $e) {
            return response()->json([
                'success' => false,
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public  function sendVideo(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'peer_id' => 'required|string',
            'video' => 'required|mimes:mp4,mov,avi|max:102400', // 100MB max
            'compress' => 'boolean'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            $result = await $this->telegramService->sendVideo(
                $request->input('peer_id'),
                $request->file('video'),
                $request->boolean('compress', true)
            );

            return response()->json([
                'success' => true,
                'data' => $result
            ]);
        } catch (\Throwable $e) {
            return response()->json([
                'success' => false,
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public  function sendVoiceMessage(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'peer_id' => 'required|string',
            'audio' => 'required|mimes:mp3,wav,ogg|max:10240', // 10MB max
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            $result = await $this->telegramService->sendVoiceMessage(
                $request->input('peer_id'),
                $request->file('audio')->getPathname()
            );

            return response()->json([
                'success' => true,
                'data' => $result
            ]);
        } catch (\Throwable $e) {
            return response()->json([
                'success' => false,
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
