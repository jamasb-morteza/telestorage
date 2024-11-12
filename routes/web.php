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
    Route::get('directory/{directoryId}/contents', [FileExplorerController::class, 'getDirectoryContents'])->name('file-explorer.directory.content');
    Route::post('directory', [FileExplorerController::class, 'createDirectory'])->name('file-explorer.directory.create');
    Route::post('file', [FileExplorerController::class, 'createFile'])->name('file-explorer.file.create');
    Route::delete('directory/{directoryId}', [FileExplorerController::class, 'deleteDirectory'])->name('file-explorer.directory.delete');
    Route::delete('file/{fileId}', [FileExplorerController::class, 'deleteFile'])->name('file-explorer.file.delete');
    Route::put('directory/{directory}/move', [FileExplorerController::class, 'moveDirectory'])->name('file-explorer.directory.move');
    Route::put('file/{fileId}/move', [FileExplorerController::class, 'moveFile'])->name('file-explorer.file.move');
    Route::put('directory/{directoryId}/rename', [FileExplorerController::class, 'renameDirectory'])->name('file-explorer.directory.rename');
    Route::put('file/{fileId}/rename', [FileExplorerController::class, 'renameFile'])->name('file-explorer.file.rename');
    Route::get('directory/{directoryId}/path', [FileExplorerController::class, 'getDirectoryPath'])->name('file-explorer.directory.path');
    Route::get('search', [FileExplorerController::class, 'search'])->name('file-explorer.search');
    Route::get('tree', [FileExplorerController::class, 'getDirectoryTree'])->name('file-explorer.tree');
    Route::put('directory/{directory}/reorder', [FileExplorerController::class, 'reorderDirectory'])->name('file-explorer.directory.reorder');
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
