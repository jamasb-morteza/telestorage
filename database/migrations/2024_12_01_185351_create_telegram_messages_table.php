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
        Schema::create('telegram_messages', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users', 'id');
            $table->string('telegram_message_id')->nullable();
            $table->string('peer_id')->nullable();
            $table->string('session_id')->nullable();
            $table->string('chat_id')->nullable();
            $table->enum('message_type', [
                'text',
                'photo',
                'video',
                'audio',
                'voice',
                'document',
                'sticker',
                'location',
                'contact',
                'poll',
                'web_page'
            ])->nullable();
            $table->text('content')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('telegram_messages');
    }
};
