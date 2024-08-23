<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Brand>
 */
class BrandFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->sentence(1),
            'image' => fake()->imageUrl(),
            'sort' => fake()->numberBetween(1, 5),
            'short_url' => fake()->slug(),
            'status' => fake()->randomElement(['enabled', 'disabled']),
            'created_at' => time(),
            'updated_at' => time(),
        ];
    }
}
