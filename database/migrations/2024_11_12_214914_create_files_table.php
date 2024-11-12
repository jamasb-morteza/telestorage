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
        Schema::create('files', function (Blueprint $table) {
            $table->id();
            $table->string('telegram_peer_id');
            $table->string('telegram_file_path');
            $table->string('telegram_message_id');
            $table->uuid('uuid')->unique();
            $table->string('name')->nullable();
            $table->string('path')->nullable();
            $table->integer('size')->nullable();
            $table->string('mime_type')->nullable();
            $table->string('extension')->nullable();
            $table->foreignId('directory_id')->constrained('directories');
            $table->foreignId('user_id')->constrained('users');
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
        Schema::dropIfExists('files');
    }
};
