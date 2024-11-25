<?php

namespace App\Services\Telegram\API;

use App\Services\Telegram\async;
use App\Services\Telegram\BaseTelegramService;
use Illuminate\Http\UploadedFile;
use const App\Services\Telegram\await;

class TelegramSendService extends BaseTelegramService
{
    public async function sendMessage(string $peerId, string $message): \Generator
    {
        try {
            return await $this->messages->sendMessage([
                'peer' => $peerId,
                'message' => $message
            ]);
        } catch (\Throwable $e) {
            \Log::error('Failed to send Telegram message: ' . $e->getMessage());
            throw $e;
        }
    }

    public async function sendVoiceMessage(string $peer, string $audioFilePath): \Generator
    {
        try {
            return await $this->messages->sendMedia([
                'peer' => $peer,
                'media' => [
                    '_' => 'inputMediaUploadedDocument',
                    'file' => $audioFilePath,
                    'attributes' => [
                        [
                            '_' => 'documentAttributeAudio',
                            'voice' => true,
                            'supports_streaming' => true
                        ]
                    ]
                ]
            ]);
        } catch (\Throwable $e) {
            \Log::error('Failed to send voice message: ' . $e->getMessage());
            throw $e;
        }
    }

    public async function sendAudioFile(string $peer, UploadedFile $audioFile): \Generator
    {
        try {
            return await $this->messages->sendMedia([
                'peer' => $peer,
                'media' => [
                    '_' => 'inputMediaUploadedDocument',
                    'file' => $audioFile->getPathname(),
                    'attributes' => [
                        [
                            '_' => 'documentAttributeAudio',
                            'voice' => false,
                            'supports_streaming' => true
                        ]
                    ]
                ]
            ]);
        } catch (\Throwable $e) {
            \Log::error('Failed to send audio file: ' . $e->getMessage());
            throw $e;
        }
    }

    public async function sendImage(string $peer, UploadedFile $imageFile, bool $compress = true): \Generator
    {
        try {
            return await $this->messages->sendMedia([
                'peer' => $peer,
                'media' => [
                    '_' => $compress ? 'inputMediaUploadedPhoto' : 'inputMediaUploadedDocument',
                    'file' => $imageFile->getPathname(),
                    'attributes' => $compress ? [] : [
                        ['_' => 'documentAttributeImageSize']
                    ]
                ]
            ]);
        } catch (\Throwable $e) {
            \Log::error('Failed to send image: ' . $e->getMessage());
            throw $e;
        }
    }

    public async function sendVideo(string $peer, UploadedFile $videoFile, bool $compress = true): \Generator
    {
        try {
            return await $this->messages->sendMedia([
                'peer' => $peer,
                'media' => [
                    '_' => 'inputMediaUploadedDocument',
                    'file' => $videoFile->getPathname(),
                    'attributes' => [
                        ['_' => 'documentAttributeVideo', 'supports_streaming' => true]
                    ],
                    'nosound_video' => false,
                    'spoiler' => false,
                    'force_file' => !$compress
                ]
            ]);
        } catch (\Throwable $e) {
            \Log::error('Failed to send video: ' . $e->getMessage());
            throw $e;
        }
    }
}
