<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Company>
 */
class CompanyFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => 1,
            'col1' => fake()->numberBetween(1, 100),
            'col2' => fake()->numberBetween(1, 10000),
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
