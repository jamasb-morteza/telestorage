<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class File extends Model
{
    protected $fillable = [
        'uuid',
        'name',
        'path',
        'size',
        'mime_type',
        'extension',
        'directory_id',
        'user_id',
        'metadata',
        'telegram_peer_id',
        'telegram_file_path',
        'telegram_message_id',
        'last_modified_at'
    ];
    protected $appends = ['type'];
    /**
     * Get the directory that owns this file
     */
    public function directory(): BelongsTo
    {
        return $this->belongsTo(Directory::class);
    }

    /**
     * Get full path of file including directory path
     */
    public function getFullPathAttribute(): string
    {
        return $this->directory->full_path . '/' . $this->name;
    }

    public function getTypeAttribute(): string
    {
        return $this->mime_type ? explode('/', $this->mime_type)[0] : 'file';
    }
}
