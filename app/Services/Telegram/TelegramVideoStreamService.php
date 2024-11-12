<?php

namespace App\Services\Telegram;

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use FFMpeg\FFMpeg;
use FFMpeg\Format\Video\X264;

class TelegramVideoStreamService extends BaseTelegramService
{
    private FFMpeg $ffmpeg;
    
    public function __construct($session, $settings)
    {
        parent::__construct($session, $settings);
        $this->ffmpeg = FFMpeg::create([
            'ffmpeg.binaries'  => config('ffmpeg.ffmpeg_path', '/usr/bin/ffmpeg'),
            'ffprobe.binaries' => config('ffmpeg.ffprobe_path', '/usr/bin/ffprobe'),
            'timeout'          => 3600, // 1 hour
            'ffmpeg.threads'   => 12,   // number of threads
        ]);
    }

    public async function streamVideo(string $peerId, string $videoPath, array $options = []): \Generator
    {
        try {
            // Default options
            $defaultOptions = [
                'chunk_size' => 2 * 1024 * 1024, // 2MB chunks
                'quality' => 'medium', // low, medium, high
                'format' => 'mp4',
                'with_audio' => true
            ];
            
            $options = array_merge($defaultOptions, $options);
            
            // Process video if needed
            $processedVideoPath = await $this->processVideo($videoPath, $options);
            
            // Get video metadata
            $video = $this->ffmpeg->open($processedVideoPath);
            $duration = $video->getStreams()->first()->get('duration');
            
            // Start streaming
            $result = await $this->messages->sendMedia([
                'peer' => $peerId,
                'media' => [
                    '_' => 'inputMediaUploadedDocument',
                    'file' => $processedVideoPath,
                    'attributes' => [
                        [
                            '_' => 'documentAttributeVideo',
                            'duration' => (int)$duration,
                            'w' => $video->getStreams()->first()->get('width'),
                            'h' => $video->getStreams()->first()->get('height'),
                            'supports_streaming' => true
                        ]
                    ],
                    'nosound_video' => !$options['with_audio']
                ]
            ]);

            // Cleanup temporary files
            if ($processedVideoPath !== $videoPath) {
                unlink($processedVideoPath);
            }

            return $result;

        } catch (\Throwable $e) {
            Log::error('Video streaming failed: ' . $e->getMessage());
            throw $e;
        }
    }

    private async function processVideo(string $videoPath, array $options): \Generator
    {
        $video = $this->ffmpeg->open($videoPath);
        
        // Define quality presets
        $qualityPresets = [
            'low' => [
                'bitrate' => '500k',
                'audioRate' => '64k',
                'resolution' => '480'
            ],
            'medium' => [
                'bitrate' => '1000k',
                'audioRate' => '128k',
                'resolution' => '720'
            ],
            'high' => [
                'bitrate' => '2000k',
                'audioRate' => '192k',
                'resolution' => '1080'
            ]
        ];
        
        $preset = $qualityPresets[$options['quality']] ?? $qualityPresets['medium'];
        
        // Create format
        $format = new X264();
        $format->setKiloBitrate((int)$preset['bitrate']);
        
        if ($options['with_audio']) {
            $format->setAudioKiloBitrate((int)$preset['audioRate']);
        }
        
        // Generate temporary file path
        $tempPath = storage_path('app/temp/' . uniqid('video_') . '.' . $options['format']);
        
        // Ensure temp directory exists
        if (!file_exists(dirname($tempPath))) {
            mkdir(dirname($tempPath), 0777, true);
        }
        
        // Process video
        $video
            ->filters()
            ->resize(new \FFMpeg\Coordinate\Dimension(
                $preset['resolution'],
                $preset['resolution']
            ))
            ->synchronize();
        
        $video->save($format, $tempPath);
        
        return $tempPath;
    }

    public async function streamLiveVideo(string $peerId, string $streamUrl): \Generator
    {
        try {
            return await $this->messages->sendMedia([
                'peer' => $peerId,
                'media' => [
                    '_' => 'inputMediaDocumentExternal',
                    'url' => $streamUrl,
                    'attributes' => [
                        [
                            '_' => 'documentAttributeVideo',
                            'supports_streaming' => true,
                            'round_message' => false,
                            'nosound' => false
                        ]
                    ]
                ]
            ]);
        } catch (\Throwable $e) {
            Log::error('Live video streaming failed: ' . $e->getMessage());
            throw $e;
        }
    }

    public async function getVideoInfo(string $videoPath): array
    {
        try {
            $video = $this->ffmpeg->open($videoPath);
            $stream = $video->getStreams()->first();
            
            return [
                'duration' => $stream->get('duration'),
                'width' => $stream->get('width'),
                'height' => $stream->get('height'),
                'codec' => $stream->get('codec_name'),
                'bitrate' => $stream->get('bit_rate'),
                'format' => pathinfo($videoPath, PATHINFO_EXTENSION)
            ];
        } catch (\Throwable $e) {
            Log::error('Failed to get video info: ' . $e->getMessage());
            throw $e;
        }
    }
} 