<?php

namespace Database\Factories;

use App\Models\Memorial;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<\App\Models\MediaAsset>
 */
class MediaAssetFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'id' => Str::ulid(),
            'memorial_id' => Memorial::factory(),
            'collection' => 'gallery',
            'disk' => 'public',
            'path' => 'memorials/'.fake()->uuid().'.jpg',
            'thumbnail_path' => null,
            'type' => 'image',
            'sort_order' => fake()->numberBetween(0, 10),
            'meta' => [
                'alt' => fake()->sentence(),
            ],
        ];
    }
}
