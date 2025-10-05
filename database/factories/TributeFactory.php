<?php

namespace Database\Factories;

use App\Models\Memorial;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<\App\Models\Tribute>
 */
class TributeFactory extends Factory
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
            'submitter_name' => fake()->name(),
            'submitter_email' => fake()->safeEmail(),
            'relationship' => fake()->randomElement(['Friend', 'Family', 'Vet', 'Neighbor']),
            'headline' => fake()->sentence(),
            'message' => fake()->paragraphs(2, true),
            'status' => 'pending',
        ];
    }

    public function approved(): self
    {
        return $this->state(fn (): array => [
            'status' => 'approved',
            'approved_at' => now(),
            'published_at' => now(),
        ]);
    }
}
