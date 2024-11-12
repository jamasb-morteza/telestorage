<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Validator;
use App\Services\Telegram\TelegramVideoStreamService;

class TelegramController
{
    public async function streamVideo(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'peer_id' => 'required|string',
            'video' => 'required|file|mimes:mp4,mov,avi|max:102400', // 100MB max
            'quality' => 'string|in:low,medium,high',
            'with_audio' => 'boolean',
            'format' => 'string|in:mp4,webm'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            $videoStreamService = app(TelegramVideoStreamService::class);
            
            $result = await $videoStreamService->streamVideo(
                $request->input('peer_id'),
                $request->file('video')->getPathname(),
                [
                    'quality' => $request->input('quality', 'medium'),
                    'with_audio' => $request->boolean('with_audio', true),
                    'format' => $request->input('format', 'mp4')
                ]
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