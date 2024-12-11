<?php

namespace App\Jobs;

use App\Models\TelegramMessage;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use App\Services\Telegram\Bot\TelegramBotSessionService;
use Illuminate\Support\Facades\Redis;
use App\Events\FileUploadProgress;

class SendTelegramMessageJob implements ShouldQueue
{
    use Queueable;

    private TelegramMessage $message;

    /**
     * Create a new job instance.
     */
    public function __construct(TelegramMessage $message)
    {
        $this->message = $message;
    }

    /**
     * Execute the job.
     */
    public function handle(TelegramBotSessionService $telegramBotSessionService): void
    {
        foreach ($this->message->files as $file) {
            $file_id = $file->id;
            $telegramBotSessionService->getAPI()->messages->sendMedia(
                peer: $this->message->peer_id,
                media: [
                    '_' => 'inputMediaUploadedDocument',
                    'file' => [
                        'file' => $file->tmp_file_path,
                        'on_progress' => function ($uploaded, $total) use ($file_id) {
                            $channel_key = "telegram:upload:{$this->message->user_id}:{$file_id}";
                            $percentage = $total > 0 ? ($uploaded / $total) * 100 : 0;
                            \Log::info('Uploading file: ' . $channel_key . ' - ' . $percentage . '%');
                            /* Redis::set($channel_key, json_encode([
                                'uploaded' => $uploaded,
                                'total' => $total,
                                'percentage' => $percentage
                            ]));
                            broadcast(new FileUploadProgress($this->message->user_id, $file_id, $percentage)); */
                        }
                    ],
                    'attributes' => [
                        ['_' => 'documentAttributeFilename', 'file_name' => $file->original_name]
                    ]
                ],
                message: 'Here is your file!'
            );
        }
    }

    public function failed(\Throwable $exception)
    {
        \Log::error('[Telegram] Sending file failed: ' . $exception->getMessage());
    }
}
