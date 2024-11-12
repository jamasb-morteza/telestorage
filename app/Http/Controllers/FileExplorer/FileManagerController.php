<?php

namespace App\Http\Controllers;

use App\Services\FileManager\FileManagerService;
use Illuminate\Http\Request;

class FileManagerController extends Controller
{
    protected $fileManager;

    public function __construct(FileManagerService $fileManager)
    {
        $this->fileManager = $fileManager;
    }

    public function index(Request $request)
    {
        $path = $request->get('path', '');
        $contents = $this->fileManager->listContents($path);
        
        return view('pages.file_explorer.master', compact('contents', 'path'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'file' => 'required|file',
            'path' => 'required|string',
        ]);

        $uploaded = $this->fileManager->uploadFile(
            $request->file('file'),
            $request->path
        );

        return response()->json([
            'success' => $uploaded,
            'message' => $uploaded ? 'File uploaded successfully' : 'Upload failed'
        ]);
    }

    public function createDirectory(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'path' => 'required|string',
        ]);

        $path = trim($request->path . '/' . $request->name, '/');
        $created = $this->fileManager->createDirectory($path);

        return response()->json([
            'success' => $created,
            'message' => $created ? 'Directory created successfully' : 'Failed to create directory'
        ]);
    }

    public function destroy(Request $request)
    {
        $request->validate([
            'path' => 'required|string',
        ]);

        $deleted = $this->fileManager->deleteItem($request->path);

        return response()->json([
            'success' => $deleted,
            'message' => $deleted ? 'Item deleted successfully' : 'Failed to delete item'
        ]);
    }
} 