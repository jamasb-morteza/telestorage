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
        $user = User::factory()->create([
            'name' => env('SUPERADMIN_NAME'),
            'email' => env('SUPERADMIN_EMAIL'),
            'username' => env('SUPERADMIN_USERNAME'),
            'phone_number' => env('SUPERADMIN_PHONE_NUMBER'),
            'ulid' => Str::orderedUuid()->toString(),
            'password' => env('SUPERADMIN_PASSWORD'),
        ]);
        // First create directories
        Directory::factory()->createSampleStructure($user->id);

        // Then create sample files in those directories
        File::factory()->createSampleFiles($user->id);

        // Or create additional random files
        // File::factory()->count(10)->create();
    }
}
