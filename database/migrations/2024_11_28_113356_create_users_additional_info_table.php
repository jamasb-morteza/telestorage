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
        Schema::table('users', function (Blueprint $table) {
            $table->json('user_info')->after('password')->nullable();
            $table->string('bot_verification_token')->after('user_info')->nullable()->index();
            $table->dateTime('bot_verification_token_expire_at')->after('bot_verification_token')->nullable()->index();
        });

        Schema::create('users_additional_info', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users', 'id');
            $table->foreignUlid('user_ulid')->constrained('users', 'ulid');
            $table->string('info_name')->index();
            $table->string('info_value')->nullable()->index();
            $table->string('type')->nullable()->default('text')->comment('text', 'phone_number', 'code', 'number', 'date');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users_additional_info');
    }
};
