<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FileExplorer\FileExplorerController;
Route::get('/', function () {
    return view('welcome');
});


// Group for file explorer routes
Route::group(['prefix' => 'file-explorer', 'middleware' => ['auth']], function () {
    
    Route::get('/', [FileExplorerController::class, 'index'])->name('file-explorer.index');
    Route::get('directory/{directoryId}/contents', [FileExplorerController::class, 'getDirectoryContents']);
    Route::post('directory', [FileExplorerController::class, 'createDirectory']);
    Route::post('file', [FileExplorerController::class, 'createFile']);
    Route::delete('directory/{directoryId}', [FileExplorerController::class, 'deleteDirectory']);
    Route::delete('file/{fileId}', [FileExplorerController::class, 'deleteFile']);
    Route::put('directory/{directory}/move', [FileExplorerController::class, 'moveDirectory']);
    Route::put('file/{fileId}/move', [FileExplorerController::class, 'moveFile']);
    Route::put('directory/{directoryId}/rename', [FileExplorerController::class, 'renameDirectory']);
    Route::put('file/{fileId}/rename', [FileExplorerController::class, 'renameFile']);
    Route::get('directory/{directoryId}/path', [FileExplorerController::class, 'getDirectoryPath']);
    Route::get('search', [FileExplorerController::class, 'search']);
    Route::get('tree', [FileExplorerController::class, 'getDirectoryTree']);
    Route::put('directory/{directory}/reorder', [FileExplorerController::class, 'reorderDirectory']);
});


Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
