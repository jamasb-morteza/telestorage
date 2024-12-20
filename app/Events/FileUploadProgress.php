<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class FileUploadProgress implements ShouldBroadcast
{
    use InteractsWithSockets, SerializesModels;

    public $user_id;
    public $file_id;
    public $percentage;

    public function __construct($userId, $fileId, $percentage)
    {
        $this->user_id = $userId;
        $this->file_id = $fileId;
        $this->percentage = $percentage;

    }

    public function broadcastOn()
    {
        $channel_key = "broadcast:upload:{$this->user_id}:{$this->file_id}";
        return new Channel($channel_key);
    }
}
