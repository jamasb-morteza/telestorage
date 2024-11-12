<?php

namespace App\Http\Controllers\FileExplorer;

use App\Http\Controllers\Controller;
use App\Services\FileExplorer\FileExplorerService;
use App\Models\Directory;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class FileExplorerController extends Controller
{
    protected FileExplorerService $fileExplorer;

    public function __construct(FileExplorerService $fileExplorer)
    {
        $this->fileExplorer = $fileExplorer;
    }

    public function index()
    {

        // Get directory tree for navigation
        $directoryTree = $this->fileExplorer->getDirectoryTree();

        // Get root directory contents
        $contents = $this->fileExplorer->getDirectoryContents(1);

        // Initialize empty breadcrumb for root level
        $breadcrumb = [];

        // Prepare view data
        $viewData = [
            'directoryTree' => $directoryTree,
            'contents' => $contents['directories']->merge($contents['files']),
            'breadcrumb' => $breadcrumb,
            'currentDirectory' => null
        ];
        
        return view('pages.file_explorer.master', $viewData);
    }

    public function getDirectoryContents(int $directoryId): JsonResponse
    {
        return response()->json(
            $this->fileExplorer->getDirectoryContents($directoryId)
        );
    }

    public function createDirectory(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'parent_id' => 'nullable|exists:directories,id'
        ]);

        $parent = $validated['parent_id'] ? Directory::find($validated['parent_id']) : null;
        $directory = $this->fileExplorer->createDirectory($validated['name'], $parent);

        if ($request->wantsJson()) {
            return response()->json($directory, 201);
        }

        return back()->with('success', 'Directory created successfully');
    }

    public function createFile(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'directory_id' => 'required|exists:directories,id',
            'size' => 'required|integer',
            'mime_type' => 'required|string',
            'extension' => 'required|string'
        ]);

        $file = $this->fileExplorer->createFile($validated);

        if ($request->wantsJson()) {
            return response()->json($file, 201);
        }

        return back()->with('success', 'File created successfully');
    }

    public function deleteDirectory(int $directoryId)
    {
        $this->fileExplorer->deleteDirectory($directoryId);

        if (request()->wantsJson()) {
            return response()->json(null, 204);
        }

        return back()->with('success', 'Directory deleted successfully');
    }

    public function deleteFile(int $fileId)
    {
        $this->fileExplorer->deleteFile($fileId);

        if (request()->wantsJson()) {
            return response()->json(null, 204);
        }

        return back()->with('success', 'File deleted successfully');
    }

    public function moveDirectory(Request $request, Directory $directory)
    {
        $validated = $request->validate([
            'new_parent_id' => 'nullable|exists:directories,id'
        ]);

        $newParent = $validated['new_parent_id'] ? Directory::find($validated['new_parent_id']) : null;
        $this->fileExplorer->moveDirectory($directory, $newParent);

        if ($request->wantsJson()) {
            return response()->json(null, 200);
        }

        return back()->with('success', 'Directory moved successfully');
    }

    public function moveFile(Request $request, int $fileId)
    {
        $validated = $request->validate([
            'new_directory_id' => 'required|exists:directories,id'
        ]);

        $this->fileExplorer->moveFile($fileId, $validated['new_directory_id']);

        if ($request->wantsJson()) {
            return response()->json(null, 200);
        }

        return back()->with('success', 'File moved successfully');
    }

    public function renameDirectory(Request $request, int $directoryId)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255'
        ]);

        $this->fileExplorer->renameDirectory($directoryId, $validated['name']);

        if ($request->wantsJson()) {
            return response()->json(null, 200);
        }

        return back()->with('success', 'Directory renamed successfully');
    }

    public function renameFile(Request $request, int $fileId)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255'
        ]);

        $this->fileExplorer->renameFile($fileId, $validated['name']);

        if ($request->wantsJson()) {
            return response()->json(null, 200);
        }

        return back()->with('success', 'File renamed successfully');
    }

    public function getDirectoryPath(int $directoryId): JsonResponse
    {
        return response()->json(
            $this->fileExplorer->getDirectoryPath($directoryId)
        );
    }

    public function search(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'query' => 'required|string|min:2',
            'directory_id' => 'nullable|exists:directories,id'
        ]);

        $directory = $validated['directory_id'] ? Directory::find($validated['directory_id']) : null;
        $results = $this->fileExplorer->searchFiles($validated['query'], $directory);

        return response()->json($results);
    }

    public function getDirectoryTree(): JsonResponse
    {
        return response()->json(
            $this->fileExplorer->getDirectoryTree()
        );
    }

    public function reorderDirectory(Request $request, Directory $directory)
    {
        $validated = $request->validate([
            'position' => 'required|integer|min:0'
        ]);

        $this->fileExplorer->reorderDirectory($directory, $validated['position']);

        if ($request->wantsJson()) {
            return response()->json(null, 200);
        }

        return back()->with('success', 'Directory reordered successfully');
    }
} 