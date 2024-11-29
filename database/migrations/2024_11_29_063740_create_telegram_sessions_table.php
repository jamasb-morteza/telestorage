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
            $table->foreignId('user_id')->nullable()->constrained(
                table: 'users',
                column: 'id',
                indexName: 'telegram_sessions_user_id_foreign'
            );
            $table->string('bot_token')->nullable();
            $table->integer('api_id')->nullable();
            $table->string('api_hash')->nullable();
            $table->string('mobile_number')->nullable()->index();
            $table->boolean('is_logged_in')->default(false);
            $table->json('additional_data')->nullable();
            $table->tinyInteger('last_session_status')->nullable();
            $table->string('last_session_status_text')->nullable();
            $table->dateTime('last_session_status_at')->nullable();
            $table->timestamp('expires_at')->nullable();
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
