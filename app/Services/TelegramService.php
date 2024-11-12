<?php

namespace App\Services;

use danog\MadelineProto\API;
use danog\MadelineProto\EventHandler;

class TelegramService extends EventHandler
{
    public function getReportPeers()
    {
        return [];
    }

    public static function startAndLoop($session, $settings)
    {
        $handler = new self($session, $settings);
        $handler->loop();
    }

    public async function onUpdateNewMessage(array $update): \Generator
    {
        if (isset($update['message']['out']) && $update['message']['out']) {
            return;
        }

        $message = $update['message'];
        
        try {
            // Handle incoming message
            await $this->messages->sendMessage([
                'peer' => $message['peer_id'],
                'message' => "Received your message: {$message['message']}",
                'reply_to_msg_id' => $message['id']
            ]);
        } catch (\Throwable $e) {
            \Log::error('Telegram error: ' . $e->getMessage());
        }
    }
    public async function sendSimpleMessage(string $peer, string $message): \Generator
    {
        try {
            return await $this->messages->sendMessage([
                'peer' => $peer,
                'message' => $message
            ]);
        } catch (\Throwable $e) {
            \Log::error('Failed to send message: ' . $e->getMessage());
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


    public async function sendAudioFile(string $peer, \Illuminate\Http\UploadedFile $audioFile): \Generator
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

    public async function sendImageWithoutCompress(string $peer, \Illuminate\Http\UploadedFile $imageFile): \Generator
    {
        try {
            return await $this->messages->sendMedia([
                'peer' => $peer,
                'media' => [
                    '_' => 'inputMediaUploadedDocument',
                    'file' => $imageFile->getPathname(),
                    'attributes' => [
                        ['_' => 'documentAttributeImageSize']
                    ]
                ]
            ]);
        } catch (\Throwable $e) {
            \Log::error('Failed to send uncompressed image: ' . $e->getMessage());
            throw $e;
        }
    }

    public async function sendImageCompressed(string $peer, \Illuminate\Http\UploadedFile $imageFile): \Generator
    {
        try {
            return await $this->messages->sendMedia([
                'peer' => $peer,
                'media' => [
                    '_' => 'inputMediaUploadedPhoto',
                    'file' => $imageFile->getPathname()
                ]
            ]);
        } catch (\Throwable $e) {
            \Log::error('Failed to send compressed image: ' . $e->getMessage());
            throw $e;
        }
    }

    public async function sendVideo(string $peer, \Illuminate\Http\UploadedFile $videoFile): \Generator
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
                    'force_file' => false
                ]
            ]);
        } catch (\Throwable $e) {
            \Log::error('Failed to send compressed video: ' . $e->getMessage());
            throw $e;
        }
    }

    public async function sendVideo(string $peer, \Illuminate\Http\UploadedFile $videoFile): \Generator
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
                    'force_file' => true // Set force_file to true to prevent compression
                ]
            ]);
        } catch (\Throwable $e) {
            \Log::error('Failed to send uncompressed video: ' . $e->getMessage());
            throw $e;
        }
    }
}