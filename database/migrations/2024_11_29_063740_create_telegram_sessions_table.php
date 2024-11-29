<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('telegram_sessions', function (Blueprint $table) {
            $table->string('session_name')->primary();
            $table->string('bot_token')->nullable();
            $table->integer('api_id')->nullable();
            $table->string('api_hash')->nullable();
            $table->boolean('is_logged_in')->default(false);
            $table->timestamp('expires_at')->nullable();
            $table->json('additional_data')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('telegram_sessions');
    }
};
