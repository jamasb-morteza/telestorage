<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Validator;
use App\Services\Telegram\TelegramVideoStreamService;
use App\Services\Telegram\TelegramAudioStreamService;

class TelegramStreamController
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

    public async function streamAudio(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'peer_id' => 'required|string',
            'audio' => 'required|file|mimes:mp3,aac,opus,ogg,wav|max:51200', // 50MB max
            'format' => 'string|in:mp3,aac,opus',
            'bitrate' => 'string|in:64k,128k,192k,256k,320k',
            'title' => 'nullable|string|max:255',
            'performer' => 'nullable|string|max:255'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            $audioStreamService = app(TelegramAudioStreamService::class);
            
            $result = await $audioStreamService->streamAudio(
                $request->input('peer_id'),
                $request->file('audio')->getPathname(),
                [
                    'format' => $request->input('format', 'mp3'),
                    'bitrate' => $request->input('bitrate', '192k'),
                    'title' => $request->input('title'),
                    'performer' => $request->input('performer')
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

    public async function streamVoiceMessage(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'peer_id' => 'required|string',
            'audio' => 'required|file|mimes:mp3,aac,opus,ogg,wav|max:10240', // 10MB max
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            $audioStreamService = app(TelegramAudioStreamService::class);
            
            $result = await $audioStreamService->streamVoice(
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