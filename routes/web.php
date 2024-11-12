<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FileExplorer\FileExplorerController;
Route::get('/', function () {
    return view('welcome');
});


// Group for file explorer routes
Route::group(['prefix' => 'file-explorer', 'middleware' => ['auth','verified']], function () {
    Route::get('/', function () {
        return view('pages.file_explorer.master');
    });
    Route::get('/', [FileExplorerController::class, 'index'])->name('file-explorer.index');
    Route::post('/', [FileExplorerController::class, 'store'])->name('file-explorer.store');
    Route::delete('/{path}', [FileExplorerController::class, 'destroy'])->name('file-explorer.destroy'); 
    Route::post('/create-directory', [FileExplorerController::class, 'createDirectory'])->name('file-explorer.create-directory');
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
