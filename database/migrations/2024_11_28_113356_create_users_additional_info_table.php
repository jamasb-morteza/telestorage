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
        });

        Schema::create('users_additional_info', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id');
            $table->foreignUlid('user_ulid');
            $table->string('info_name')->index();
            $table->string('info_value')->nullable()->index();
            $table->string('type')->nullable()->default('text')->comment('text', 'phone_number', 'code', 'number', 'date');
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('user_ulid')->references('ulid')->on('users');
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
