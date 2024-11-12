<?php

namespace App\Services\FileExplorer;

use App\Models\Directory;
use App\Models\File;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;

class FileExplorerService
{
    public function createDirectory(string $name, ?Directory $parent = null): Directory
    {
        $directory = new Directory([
            'name' => $name,
            'user_id' => Auth::id(),
            'uuid' => Str::uuid()
        ]);

        if ($parent) {
            $directory->appendToNode($parent)->save();
        } else {
            $directory->saveAsRoot();
        }

        return $directory;
    }

    public function getDirectoryContents(int $directoryId)
    {
        $directory = Directory::findOrFail($directoryId);
        
        $subdirectories = $directory->children()
            ->defaultOrder()
            ->get();
            
        $files = $directory->files()
            ->select(['id', 'name', 'size', 'mime_type', 'path', 'extension', 'created_at', 'updated_at'])
            ->get();
            
        return [
            'directories' => $subdirectories,
            'files' => $files
        ];
    }

    public function createFile(array $attributes): File
    {
        return File::create(array_merge(
            $attributes,
            [
                'user_id' => Auth::id(),
                'uuid' => Str::uuid()
            ]
        ));
    }

    public function deleteDirectory(int $directoryId): bool
    {
        $directory = Directory::findOrFail($directoryId);
        
        // Delete all files in directory and descendants
        File::whereIn('directory_id', 
            $directory->descendants()
                ->pluck('id')
                ->push($directoryId)
        )->delete();
        
        return $directory->delete();
    }

    public function deleteFile(int $fileId): bool
    {
        return File::findOrFail($fileId)->delete();
    }

    public function moveDirectory(Directory $directory, ?Directory $newParent = null): bool
    {
        if ($newParent) {
            return $directory->appendToNode($newParent)->save();
        }
        
        return $directory->saveAsRoot();
    }

    public function moveFile(int $fileId, int $newDirectoryId): bool
    {
        $file = File::findOrFail($fileId);
        $file->directory_id = $newDirectoryId;
        return $file->save();
    }

    public function renameDirectory(int $directoryId, string $newName): bool
    {
        $directory = Directory::findOrFail($directoryId);
        $directory->name = $newName;
        return $directory->save();
    }

    public function renameFile(int $fileId, string $newName): bool
    {
        $file = File::findOrFail($fileId);
        $file->name = $newName;
        return $file->save();
    }

    public function getDirectoryPath(int $directoryId): array
    {
        $directory = Directory::findOrFail($directoryId);
        return $directory->ancestors()
            ->defaultOrder()
            ->get()
            ->push($directory)
            ->map(function($dir) {
                return [
                    'id' => $dir->id,
                    'name' => $dir->name
                ];
            })
            ->all();
    }

    public function searchFiles(string $query, ?Directory $directory = null)
    {
        $filesQuery = File::query()
            ->where('name', 'like', "%{$query}%");
            
        if ($directory) {
            $descendantIds = $directory->descendants()->pluck('id')->push($directory->id);
            $filesQuery->whereIn('directory_id', $descendantIds);
        }
        
        return $filesQuery->get();
    }

    public function getDirectoryTree()
    {
        return Directory::defaultOrder()->get()->toTree();
    }

    public function reorderDirectory(Directory $directory, int $position): bool
    {
        if ($directory->parent_id) {
            return $directory->siblings()->move($position);
        }
        return $directory->rootNode()->move($position);
    }
}

