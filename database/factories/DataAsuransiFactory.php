<?php
/**
 * Budi Prastyo <budi@prastyo.com>
 * created_at : 2024-10-10 17:36:08
 */

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class DataAsuransiFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        // Available Formatters https://fakerphp.org/formatters/numbers-and-strings/
        $createdAt = fake()->dateTimeBetween('-3 year'); // Generate dates from now until 3 years ago
        return [
            'created_at'    => $createdAt,
            'updated_at'    => $createdAt,
            'nama'          => fake()->name(), // fake()->unique()->words(2, true),
            'created_by'    => User::inRandomOrder()->first()
        ];
    }
}