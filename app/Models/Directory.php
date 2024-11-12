<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Kalnoy\Nestedset\NodeTrait;

class Directory extends Model
{
    
    use NodeTrait, HasFactory;

    protected $fillable = [
        'name',
        'path',
        'uuid',
        'user_id'
    ];
    protected $appends = ['type'];
    /**
     * Get all files in this directory
     */
    public function files(): HasMany
    {
        return $this->hasMany(\App\Models\File::class);
    }

    /**
     * Get full path of directory
     */
    public function getFullPathAttribute(): string
    {
        return $this->ancestors->pluck('name')->push($this->name)->implode('/');
    }

    /**
     * Custom method to create a directory at a specific path
     */
    public static function createAtPath(string $path)
    {
        $segments = array_filter(explode('/', $path));
        $parent = null;
        $current = null;

        foreach ($segments as $segment) {
            $current = static::firstOrCreate(
                [
                    'name' => $segment,
                    'parent_id' => optional($parent)->id
                ]
            );
            $parent = $current;
        }

        return $current;
    }

    public function getTypeAttribute(): string
    {
        return 'directory';
    }
}

