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
            $table->id();
            $table->foreignId('user_id')->constrained(
                table: 'users', indexName: 'telegram_sessions_user_id_foreign'
            );
            $table->string('session_name')->index();
            $table->string('mobile_number')->index();
            $table->json('session_data')->nullable();
            $table->string('last_session_status_text')->nullable();
            $table->tinyInteger('last_session_status')->nullable();
            $table->dateTime('last_session_status_at')->nullable();
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
