<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TelegramClient extends Model
{
    //
    protected $fillable = [
        'id',
        'user_id',
        'telegram_username',
        'telestorage_token',
        'telegram_user_id',
        'telegram_bot_api_id',
        'client_details',
        'type',
    ];
}
