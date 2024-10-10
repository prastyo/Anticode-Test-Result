<?php
/**
 * Budi Prastyo <budi@prastyo.com>
 * created_at : 2024-10-10 17:36:08
 */

namespace Database\Factories;

use App\Models\User;
use App\Enums\JenisKeuanganEnum;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class KeuanganFactory extends Factory
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
            'created_at'          => $createdAt,
            'updated_at'          => $createdAt,
            'tahun_anggaran'      => fake()->year(), // 2024,
            'keterangan'          => fake()->sentence(), // Sit vitae voluptas sint non voluptates,
            'tanggal_kuitansi'    => fake()->date('d-m-Y'), // in the model Keuangan that uses the d-m-Y format,
            'nilai_anggaran'      => fake()->numerify('##0000'), // Generate a string where all # characters are replaced by digits between 0 and 9,
            'nilai_realisasi'     => fake()->numerify('##0000'), // Generate a string where all # characters are replaced by digits between 0 and 9,
            'created_by'          => User::inRandomOrder()->first(),
            'jenis_keuangan'      => fake()->randomElement(JenisKeuanganEnum::cases())->value
        ];
    }
}