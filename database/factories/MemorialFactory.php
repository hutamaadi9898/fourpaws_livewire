<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<\App\Models\Memorial>
 */
class MemorialFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $title = fake()->sentence(3);

        return [
            'id' => Str::ulid(),
            'owner_id' => User::factory(),
            'title' => $title,
            'slug' => Str::slug($title).'-'.fake()->unique()->lexify('????'),
            'pet_name' => fake()->firstName(),
            'headline' => fake()->sentence(),
            'summary' => fake()->paragraph(),
            'story' => fake()->paragraphs(4, true),
            'theme' => [
                'primary' => fake()->hexColor(),
                'accent' => fake()->hexColor(),
            ],
            'status' => 'published',
            'visibility' => 'public',
            'hero_image_path' => 'memorials/sample-'.fake()->numberBetween(1, 5).'.jpg',
            'published_at' => now(),
        ];
    }

    public function draft(): self
    {
        return $this->state(fn (): array => [
            'status' => 'draft',
            'published_at' => null,
            'visibility' => 'private',
        ]);
    }
}
