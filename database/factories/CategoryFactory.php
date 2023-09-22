<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Category>
 */
class CategoryFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $status = ['active' , 'archive'];
        return [
             'name' => fake()->name(),
            'slug' => fake()->unique()->slug(),
            'status' => $status[array_rand($status , 1)],
            'description' => fake()->text()
        ];
    }
}