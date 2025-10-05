<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<\App\Models\WaitlistSignup>
 */
class WaitlistSignupFactory extends Factory
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
            'email' => fake()->unique()->safeEmail(),
            'name' => fake()->name(),
            'source' => fake()->randomElement(['landing', 'referral', 'ad']),
            'meta' => [
                'utm_campaign' => fake()->slug(),
            ],
            'confirmed_at' => null,
        ];
    }

    public function confirmed(): self
    {
        return $this->state(fn (): array => [
            'confirmed_at' => now(),
        ]);
    }
}
