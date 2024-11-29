<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TelegramSession extends Model
{
    protected $table = 'telegram_sessions';
    protected $primaryKey = 'session_name';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'session_name',
        'bot_token',
        'is_logged_in',
        'api_id',
        'api_hash',
        'expires_at',
        'additional_data'
    ];

    protected $casts = [
        'is_logged_in' => 'boolean',
        'expires_at' => 'datetime',
        'additional_data' => 'array'
    ];

    /**
     * Check if the session is still valid
     */
    public function isValid(): bool
    {
        return $this->is_logged_in &&
            ($this->expires_at === null || $this->expires_at > now());
    }
}
