<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class FileUploadProgress implements ShouldBroadcast
{
    use InteractsWithSockets, SerializesModels;

    public $userId;
    public $fileId;
    public $percentage;

    public function __construct($userId, $fileId, $percentage)
    {
        $this->userId = $userId;
        $this->fileId = $fileId;
        $this->percentage = $percentage;
    }

    public function broadcastOn()
    {
        return new Channel('file-upload.' . $this->userId);
    }
}
