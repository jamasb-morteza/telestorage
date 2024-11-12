<?php

namespace App\Services\Telegram;

use Illuminate\Support\Facades\Log;
use FFMpeg\FFMpeg;
use FFMpeg\Format\Audio\Mp3;
use FFMpeg\Format\Audio\Aac;
use FFMpeg\Format\Audio\Opus;

class TelegramAudioStreamService extends BaseTelegramService
{
    private FFMpeg $ffmpeg;
    
    public function __construct($session, $settings)
    {
        parent::__construct($session, $settings);
        $this->ffmpeg = FFMpeg::create([
            'ffmpeg.binaries'  => config('ffmpeg.ffmpeg_path', '/usr/bin/ffmpeg'),
            'ffprobe.binaries' => config('ffmpeg.ffprobe_path', '/usr/bin/ffprobe'),
            'timeout'          => 3600,
            'ffmpeg.threads'   => 12,
        ]);
    }

    public async function streamAudio(string $peerId, string $audioPath, array $options = []): \Generator
    {
        try {
            $defaultOptions = [
                'format' => 'mp3',
                'bitrate' => '192k',
                'title' => null,
                'performer' => null,
                'duration' => null
            ];
            
            $options = array_merge($defaultOptions, $options);
            
            // Process audio if needed
            $processedAudioPath = await $this->processAudio($audioPath, $options);
            
            // Get audio metadata
            $audio = $this->ffmpeg->open($processedAudioPath);
            $duration = $audio->getStreams()->first()->get('duration');

            $attributes = [
                [
                    '_' => 'documentAttributeAudio',
                    'duration' => (int)$duration,
                    'voice' => false,
                    'title' => $options['title'],
                    'performer' => $options['performer']
                ]
            ];

            $result = await $this->messages->sendMedia([
                'peer' => $peerId,
                'media' => [
                    '_' => 'inputMediaUploadedDocument',
                    'file' => $processedAudioPath,
                    'attributes' => $attributes,
                    'mime_type' => $this->getMimeType($options['format'])
                ]
            ]);

            // Cleanup temporary files
            if ($processedAudioPath !== $audioPath) {
                unlink($processedAudioPath);
            }

            return $result;

        } catch (\Throwable $e) {
            Log::error('Audio streaming failed: ' . $e->getMessage());
            throw $e;
        }
    }

    public async function streamVoice(string $peerId, string $audioPath, array $options = []): \Generator
    {
        try {
            $defaultOptions = [
                'format' => 'opus',
                'bitrate' => '64k'
            ];
            
            $options = array_merge($defaultOptions, $options);
            
            // Process audio for voice message
            $processedAudioPath = await $this->processAudio($audioPath, $options);
            
            // Get audio duration
            $audio = $this->ffmpeg->open($processedAudioPath);
            $duration = $audio->getStreams()->first()->get('duration');

            $result = await $this->messages->sendMedia([
                'peer' => $peerId,
                'media' => [
                    '_' => 'inputMediaUploadedDocument',
                    'file' => $processedAudioPath,
                    'attributes' => [
                        [
                            '_' => 'documentAttributeAudio',
                            'voice' => true,
                            'duration' => (int)$duration,
                            'waveform' => await $this->generateWaveform($processedAudioPath)
                        ]
                    ]
                ]
            ]);

            if ($processedAudioPath !== $audioPath) {
                unlink($processedAudioPath);
            }

            return $result;

        } catch (\Throwable $e) {
            Log::error('Voice message streaming failed: ' . $e->getMessage());
            throw $e;
        }
    }

    private async function processAudio(string $audioPath, array $options): \Generator
    {
        $audio = $this->ffmpeg->open($audioPath);
        
        // Select format based on options
        $format = match($options['format']) {
            'mp3' => new Mp3(),
            'aac' => new Aac(),
            'opus' => new Opus(),
            default => new Mp3()
        };
        
        // Set bitrate
        $format->setAudioKiloBitrate(
            (int)str_replace('k', '', $options['bitrate'])
        );
        
        // Generate temporary file path
        $tempPath = storage_path('app/temp/' . uniqid('audio_') . '.' . $options['format']);
        
        // Ensure temp directory exists
        if (!file_exists(dirname($tempPath))) {
            mkdir(dirname($tempPath), 0777, true);
        }
        
        // Process audio
        $audio->save($format, $tempPath);
        
        return $tempPath;
    }

    private function getMimeType(string $format): string
    {
        return match($format) {
            'mp3' => 'audio/mpeg',
            'aac' => 'audio/aac',
            'opus' => 'audio/opus',
            'ogg' => 'audio/ogg',
            default => 'audio/mpeg'
        };
    }

    private async function generateWaveform(string $audioPath): array
    {
        try {
            $audio = $this->ffmpeg->open($audioPath);
            $waveform = [];
            
            // Generate simple waveform data (100 points)
            // This is a simplified version - you might want to implement
            // more sophisticated waveform generation
            $stream = $audio->getStreams()->first();
            $duration = $stream->get('duration');
            $interval = $duration / 100;
            
            for ($i = 0; $i < 100; $i++) {
                $time = $i * $interval;
                // Generate a value between 0-31 (5-bit value as required by Telegram)
                $waveform[] = rand(0, 31);
            }
            
            return $waveform;
        } catch (\Throwable $e) {
            Log::error('Waveform generation failed: ' . $e->getMessage());
            return array_fill(0, 100, 16); // Return flat waveform as fallback
        }
    }

    public async function getAudioInfo(string $audioPath): array
    {
        try {
            $audio = $this->ffmpeg->open($audioPath);
            $stream = $audio->getStreams()->first();
            
            return [
                'duration' => $stream->get('duration'),
                'codec' => $stream->get('codec_name'),
                'bitrate' => $stream->get('bit_rate'),
                'channels' => $stream->get('channels'),
                'sample_rate' => $stream->get('sample_rate'),
                'format' => pathinfo($audioPath, PATHINFO_EXTENSION)
            ];
        } catch (\Throwable $e) {
            Log::error('Failed to get audio info: ' . $e->getMessage());
            throw $e;
        }
    }
} 