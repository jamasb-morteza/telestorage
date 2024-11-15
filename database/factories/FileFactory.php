<?php

namespace Database\Factories;

use App\Models\File;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\File>
 */
class FileFactory extends Factory
{
    protected $model = File::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->word() . '.' . $this->faker->fileExtension(),
            'directory_id' => null,
            'uuid' => $this->faker->uuid(),
            'size' => $this->faker->numberBetween(1024, 10485760), // 1KB to 10MB
            'mime_type' => $this->faker->mimeType(),
            'user_id' => function () {
                return \App\Models\User::factory()->create()->id;
            },
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }

    public function createSampleFiles()
    {
        // Get directories by name
        $directories = \App\Models\Directory::all()->keyBy('name');

        // Create document files
        File::factory()->create([
            'name' => 'annual_report_2023.pdf',
            'directory_id' => $directories['Reports']->id,
            'mime_type' => 'application/pdf',
        ]);
        
        File::factory()->create([
            'name' => 'project_plan.docx',
            'directory_id' => $directories['Projects']->id,
            'mime_type' => 'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
        ]);

        // Create tax documents
        File::factory()->create([
            'name' => 'tax_return_2023.pdf',
            'directory_id' => $directories['Taxes']->id,
            'mime_type' => 'application/pdf',
        ]);

        // Create receipts
        File::factory()->create([
            'name' => 'amazon_purchase.pdf',
            'directory_id' => $directories['Receipts']->id,
            'mime_type' => 'application/pdf',
        ]);

        // Create pictures
        File::factory()->create([
            'name' => 'beach_sunset.jpg',
            'directory_id' => $directories['Vacation']->id,
            'mime_type' => 'image/jpeg',
        ]);
        
        File::factory()->create([
            'name' => 'family_reunion.jpg',
            'directory_id' => $directories['Family']->id,
            'mime_type' => 'image/jpeg',
        ]);

        // Create music files
        File::factory()->create([
            'name' => 'bohemian_rhapsody.mp3',
            'directory_id' => $directories['Rock']->id,
            'mime_type' => 'audio/mpeg',
        ]);
        
        File::factory()->create([
            'name' => 'take_five.mp3',
            'directory_id' => $directories['Jazz']->id,
            'mime_type' => 'audio/mpeg',
        ]);
        
        File::factory()->create([
            'name' => 'moonlight_sonata.mp3',
            'directory_id' => $directories['Classical']->id,
            'mime_type' => 'audio/mpeg',
        ]);
    }
} 