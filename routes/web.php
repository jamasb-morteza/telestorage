<?php

use App\Http\Controllers\FileExplorer\FileExplorerController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Telegram\TelegramAPI\TelegramAuthController;
use Illuminate\Support\Facades\Route;

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
    return view('pages.dashboard.master');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::prefix('telegram')->name('telegram.')->group(function () {
    // QR Code Authentication
    Route::get('/qr-login', [TelegramAuthController::class, 'generateQrCode'])->name('qr-login');
    Route::get('/qr-status', [TelegramAuthController::class, 'checkQrStatus'])->name('qr-status');

    // Phone Authentication
    Route::post('/phone-login', [TelegramAuthController::class, 'phoneLogin'])->name('phone-login');
    Route::post('/verify-code', [TelegramAuthController::class, 'verifyCode'])->name('verify-code');

    // Password Authentication (2FA if enabled)
    Route::post('/verify-password', [TelegramAuthController::class, 'verifyPassword'])->name('verify-password');

    // Session Management
    Route::post('/logout', [TelegramAuthController::class, 'logout'])->name('logout');
    Route::get('/status', [TelegramAuthController::class, 'checkAuthStatus'])->name('status');
});

require __DIR__ . '/auth.php';
