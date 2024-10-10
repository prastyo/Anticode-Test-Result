<?php
/**
 * Budi Prastyo <budi@prastyo.com>
 * created_at : 2024-10-10 17:36:08
 */

namespace Database\Factories;

use App\Models\User;
use App\Models\Penduduk;
use App\Models\DataJabatan;
use App\Enums\StatusPejabatEnum;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class PerangkatFactory extends Factory
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
            'created_at'                         => $createdAt,
            'updated_at'                         => $createdAt,
            'tanggal_keputusan_pengangkatan'     => fake()->date('d-m-Y'), // in the model Perangkat that uses the d-m-Y format,
            'tanggal_keputusan_pemberhentian'    => fake()->date('d-m-Y'), // in the model Perangkat that uses the d-m-Y format,
            'nipd'                               => fake()->randomNumber(9, true), // When the parameter is true, it will only return integers with a specific number of digits,
            'nip'                                => fake()->randomNumber(9, true), // When the parameter is true, it will only return integers with a specific number of digits,
            'no_keputusan_pengangkatan'          => fake()->randomNumber(9, true), // When the parameter is true, it will only return integers with a specific number of digits,
            'no_keputusan_pemberhentian'         => fake()->randomNumber(9, true), // When the parameter is true, it will only return integers with a specific number of digits,
            'created_by'                         => User::inRandomOrder()->first(),
            'pangkat_golongan'                   => fake()->unique()->words(2, true), // Generate 2 unique words,
            'masa_jabatan'                       => fake()->unique()->words(2, true), // Generate 2 unique words,
            'penduduk_id'                        => Penduduk::inRandomOrder()->first(),
            'jabatan_id'                         => DataJabatan::inRandomOrder()->first(),
            'status_pejabat'                     => fake()->randomElement(StatusPejabatEnum::cases())->value
        ];
    }
}