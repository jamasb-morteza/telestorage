<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class TelegramMessage extends Model
{
    protected $fillable = [
        'message_type',
        'user_id',
        'session_id',
        'peer_id',
        'chat_id',
        'message_id',
        'message_data'
    ];

    public function files(): HasMany
    {
        return $this->hasMany(TelegramFile::class, 'message_id', 'id');
    }
}
