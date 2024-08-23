<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
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
            'sort' => fake()->numberBetween(1, 5),
            'model' => fake()->regexify('[A-Z]{3}[0-9]{3}'),
            'price' => fake()->randomFloat(2),
            'image' => fake()->imageUrl(),
            'banner' => fake()->imageUrl(),
            'points' => fake()->numberBetween(1, 5),
            'status' => fake()->randomElement(['enabled', 'disabled']),
            'trending' => fake()->numberBetween(0, 1),
            'subtract' => fake()->numberBetween(0, 1),
            'quantity' => fake()->numberBetween(1, 1000),
            'brand_id' => fake()->numberBetween(1, 5),
            'short_url' => fake()->slug(),
            'min_quantity' => fake()->numberBetween(1, 10),
            'description' => fake()->realText(),
            'created_at' => time(),
            'updated_at' => time(),
        ];
    }
}
