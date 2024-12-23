<?php

namespace App\Services\FileManager;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;

class FileManagerService
{
    protected $disk;

    public function __construct($disk = 'local')
    {
        $this->disk = Storage::disk($disk);
    }

    public function listContents($path = '')
    {
        $contents = collect($this->disk->listContents($path, false));
        
        return $contents->map(function ($item) {
            $name = $item->path();
            $name = basename($name);
            
            return [
                'name' => $name,
                'path' => $item->path(),
                'type' => $item->type(),
                'size' => $item->type() === 'file' ? ($item->fileSize() ?? 0) : 0,
                'human_size' => $item->type() === 'file' ? $this->formatSize($item->fileSize() ?? 0) : '',
                'last_modified' => date('Y-m-d H:i', $item->lastModified()),
                'modified' => $item->lastModified(),
                'extension' => pathinfo($item->path(), PATHINFO_EXTENSION),
            ];
        })->sortBy('type');
    }

    public function createDirectory($path)
    {
        return $this->disk->makeDirectory($path);
    }

    public function deleteItem($path)
    {
        if ($this->disk->exists($path)) {
            return $this->disk->delete($path);
        }
        return false;
    }

    public function uploadFile($file, $path)
    {
        return $this->disk->putFileAs($path, $file, $file->getClientOriginalName());
    }

    protected function formatSize($size)
    {
        $units = ['B', 'KB', 'MB', 'GB', 'TB'];
        $power = $size > 0 ? floor(log($size, 1024)) : 0;
        return number_format($size / pow(1024, $power), 2, '.', ',') . ' ' . $units[$power];
    }
} 