<?php

namespace Database\Factories;

use App\Models\Directory;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Directory>
 */
class DirectoryFactory extends Factory
{
    protected $model = Directory::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->word(),
            'parent_id' => null,
            'uuid' => $this->faker->uuid(),
            'user_id' => function () {
                return \App\Models\User::factory()->create()->id;
            },
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }

    public function createSampleStructure()
    {
        // Create root directories
        $root = Directory::factory()->create(['name' => 'Root', 'parent_id' => null]);
        $documents = Directory::factory()->create(['name' => 'Documents', 'parent_id' => $root->id]);
        $pictures = Directory::factory()->create(['name' => 'Pictures', 'parent_id' => $root->id]);
        $music = Directory::factory()->create(['name' => 'Music', 'parent_id' => $root->id]);

        // Create nested directories in Documents
        $work = Directory::factory()->create(['name' => 'Work', 'parent_id' => $documents->id]);
        $personal = Directory::factory()->create(['name' => 'Personal', 'parent_id' => $documents->id]);
        
        // Create deeper nested directories in Work
        Directory::factory()->create(['name' => 'Projects', 'parent_id' => $work->id]);
        Directory::factory()->create(['name' => 'Reports', 'parent_id' => $work->id]);
        
        // Create nested directories in Personal
        Directory::factory()->create(['name' => 'Taxes', 'parent_id' => $personal->id]);
        Directory::factory()->create(['name' => 'Receipts', 'parent_id' => $personal->id]);

        // Create nested directories in Pictures
        Directory::factory()->create(['name' => 'Vacation', 'parent_id' => $pictures->id]);
        Directory::factory()->create(['name' => 'Family', 'parent_id' => $pictures->id]);

        // Create nested directories in Music
        Directory::factory()->create(['name' => 'Rock', 'parent_id' => $music->id]);
        Directory::factory()->create(['name' => 'Jazz', 'parent_id' => $music->id]);
        Directory::factory()->create(['name' => 'Classical', 'parent_id' => $music->id]);
    }
}
