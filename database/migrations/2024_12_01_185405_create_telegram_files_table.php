<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('telegram_files', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();
            $table->foreignId('user_id')->constrained('users', 'id');
            $table->foreignId('message_id')->constrained('telegram_messages', 'id');
            $table->foreignId('directory_id')->constrained('directories', 'id');
            $table->string('peer_id')->nullable();
            $table->string('telegram_file_path')->nullable();
            $table->string('telegram_message_id')->nullable();
            $table->enum('telegram_file_type', [
                'document',
                'photo',
                'video',
                'audio',
                'voice',
                'video_note',
                'sticker',
                'location',
                'contact',
                'poll',
                'web_page'
            ])->nullable();
            $table->string('name')->nullable();
            $table->string('path')->nullable();
            $table->integer('size')->nullable();
            $table->string('mime_type')->nullable();
            $table->string('extension')->nullable();
            $table->json('metadata')->nullable()->default(null);
            $table->dateTime('last_modified_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('telegram_files');
    }
};
