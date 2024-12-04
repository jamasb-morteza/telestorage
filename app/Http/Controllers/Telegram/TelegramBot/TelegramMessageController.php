<?php

namespace App\Http\Controllers\Telegram\TelegramBot;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\TelegramMessage;
use App\Jobs\SendTelegramMessageJob;
class TelegramMessageController extends Controller
{
    public function sendMessage(Request $request)
    {
        // Validate request
        $validated = $request->validate([
            'peer_id' => 'required',
            'files' => 'required|array',
            'files.*.path' => 'required|string',
            'files.*.name' => 'required|string',
            'files.*.size' => 'required|integer',
            'files.*.mime_type' => 'required|string',
        ]);

        // Create telegram message
        $message = TelegramMessage::create([
            'message_type' => 'media',
            'user_id' => auth()->id(),
            'peer_id' => $validated['peer_id'],
            'message_data' => $request->except('files'),
        ]);

        // Create telegram files
        foreach ($validated['files'] as $fileData) {
            $message->files()->create([
                'user_id' => auth()->id(),
                'name' => $fileData['name'],
                'path' => $fileData['path'],
                'size' => $fileData['size'],
                'mime_type' => $fileData['mime_type'],
                'tmp_file_path' => storage_path('app/' . $fileData['path']),
            ]);
        }

        // Dispatch job
        dispatch(new SendTelegramMessageJob($message));

        return response()->json([
            'message' => 'Message dispatched successfully',
            'message_id' => $message->id
        ]);
    }

    public function uploadFile(Request $request)
    {
        // Validate request
        $validated = $request->validate([
            'files' => 'required|array',
            'files.*' => 'required|file',
        ]);

        // Process each file
        $filesData = [];
        foreach ($validated['files'] as $file) {
            $path = $file->store('uploads');
            $filesData[] = [
                'name' => $file->getClientOriginalName(),
                'path' => $path,
                'size' => $file->getSize(),
                'mime_type' => $file->getMimeType(),
            ];
        }

        // Dispatch job
        $message = TelegramMessage::create([
            'message_type' => 'media',
            'user_id' => auth()->id(),
            'peer_id' => $request->input('peer_id'),
            'message_data' => $request->except('files'),
        ]);

        foreach ($filesData as $fileData) {
            $message->files()->create($fileData);
        }

        dispatch(new SendTelegramMessageJob($message));

        return response()->json(['message' => 'Files uploaded successfully']);
    }
}
