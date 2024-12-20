<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Directory;
use App\Models\File;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $user_data = [
            'name' => config('app.super_admin.name'),
            'email' => config('app.super_admin.email'),
            'username' => config('app.super_admin.username'),
            'phone_number' => config('app.super_admin.phone_number'),
            'password' => config('app.super_admin.password'),
            'ulid' => Str::orderedUuid()->toString(),
        ];

        dump(compact('user_data'));
        $user = User::factory()->create($user_data);
        // First create directories
        Directory::factory()->createSampleStructure($user->id);

        // Then create sample files in those directories
        File::factory()->createSampleFiles($user->id);

        // Or create additional random files
        // File::factory()->count(10)->create();
    }
}
