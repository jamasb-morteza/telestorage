<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Directory;
use App\Models\File;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $user = User::factory()->create(['email' => 'jamaseb.morteza@gmail.com','name' => 'Jamasb Morteza','password' => '123654Aa!']);  
        // First create directories
        Directory::factory()->createSampleStructure($user->id);
        
        // Then create sample files in those directories
        File::factory()->createSampleFiles($user->id);
        
        // Or create additional random files
        // File::factory()->count(10)->create();
    }
}
