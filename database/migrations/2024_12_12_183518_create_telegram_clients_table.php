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
        Schema::dropIfExists('telegram_clients');
        Schema::create('telegram_clients', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users', 'id');
            $table->string('telestorage_token', 36)->nullable();
            $table->bigInteger('telegram_user_id')->nullable()->index();
            $table->string('telegram_username', 64)->nullable()->index();
            $table->bigInteger('telegram_bot_api_id')->nullable()->index();
            $table->json('client_details')->nullable();
            $table->string('type')->nullable()->index();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('telegram_clients');
    }
};
