<?php

namespace App\Services\Telegram\API;

use App\Services\Telegram\async;
use App\Services\Telegram\BaseTelegramService;
use const App\Services\Telegram\await;

class TelegramReceiveService extends BaseTelegramService
{
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
}
