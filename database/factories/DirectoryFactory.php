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

    public function createSampleStructure($user_id)
    {
        // Create root directories
        $root = Directory::factory()->create(['user_id' => $user_id, 'name' => 'Root', 'parent_id' => null]);
        $documents = Directory::factory()->create(['user_id' => $user_id, 'name' => 'Documents', 'parent_id' => $root->id]);
        $pictures = Directory::factory()->create(['user_id' => $user_id, 'name' => 'Pictures', 'parent_id' => $root->id]);
        $music = Directory::factory()->create(['user_id' => $user_id, 'name' => 'Music', 'parent_id' => $root->id]);

        // Create nested directories in Documents
        $work = Directory::factory()->create(['user_id' => $user_id, 'name' => 'Work', 'parent_id' => $documents->id]);
        $personal = Directory::factory()->create(['user_id' => $user_id, 'name' => 'Personal', 'parent_id' => $documents->id]);

        // Create deeper nested directories in Work
        Directory::factory()->create(['user_id' => $user_id, 'name' => 'Projects', 'parent_id' => $work->id]);
        Directory::factory()->create(['user_id' => $user_id, 'name' => 'Reports', 'parent_id' => $work->id]);

        // Create nested directories in Personal
        Directory::factory()->create(['user_id' => $user_id, 'name' => 'Taxes', 'parent_id' => $personal->id]);
        Directory::factory()->create(['user_id' => $user_id, 'name' => 'Receipts', 'parent_id' => $personal->id]);

        // Create nested directories in Pictures
        Directory::factory()->create(['user_id' => $user_id, 'name' => 'Vacation', 'parent_id' => $pictures->id]);
        Directory::factory()->create(['user_id' => $user_id, 'name' => 'Family', 'parent_id' => $pictures->id]);

        // Create nested directories in Music
        Directory::factory()->create(['user_id' => $user_id, 'name' => 'Rock', 'parent_id' => $music->id]);
        Directory::factory()->create(['user_id' => $user_id, 'name' => 'Jazz', 'parent_id' => $music->id]);
        Directory::factory()->create(['user_id' => $user_id, 'name' => 'Classical', 'parent_id' => $music->id]);
    }
}
