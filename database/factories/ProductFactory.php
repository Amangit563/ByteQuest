<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Models\User;

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
            'admin_id' => User::inRandomOrder()->first()->id,
            'name' => fake()->word(),
            'price' => fake()->randomFloat(2, 1000, 100000),
            'description' => fake()->sentence(),
            'image' => 'default.png',
        ];
    }
}
