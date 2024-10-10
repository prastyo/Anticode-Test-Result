<?php
/**
 * Budi Prastyo <budi@prastyo.com>
 * created_at : 2024-10-10 17:36:08
 */

namespace Database\Factories;

use App\Models\User;
use App\Models\Penduduk;
use App\Enums\JenisKelaminEnum;
use App\Models\DataJenisPersalinan;
use App\Models\DataTempatDilahirkan;
use App\Models\DataPenolongKelahiran;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class KelahiranFactory extends Factory
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
            'created_at'               => $createdAt,
            'updated_at'               => $createdAt,
            'tempat_lahir'             => fake()->city(),
            'jam_lahir'                => fake()->time(),
            'nama_anak'                => fake()->name(), // fake()->unique()->words(2, true),
            'hari_lahir'               => fake()->dayOfWeek(),
            'tanggal_lahir'            => fake()->date('d-m-Y'), // in the model Kelahiran that uses the d-m-Y format,
            'anak_ke'                  => fake()->randomNumber(9, true), // When the parameter is true, it will only return integers with a specific number of digits,
            'berat_bayi'               => fake()->randomNumber(9, true), // When the parameter is true, it will only return integers with a specific number of digits,
            'panjang_bayi'             => fake()->randomNumber(9, true), // When the parameter is true, it will only return integers with a specific number of digits,
            'created_by'               => User::inRandomOrder()->first(),
            'ayah_id'                  => Penduduk::inRandomOrder()->first(),
            'ibu_id'                   => Penduduk::inRandomOrder()->first(),
            'jenis_persalinan_id'      => DataJenisPersalinan::inRandomOrder()->first(),
            'tempat_dilahirkan_id'     => DataTempatDilahirkan::inRandomOrder()->first(),
            'penolong_kelahiran_id'    => DataPenolongKelahiran::inRandomOrder()->first(),
            'jenis_kelamin'            => fake()->randomElement(JenisKelaminEnum::cases())->value
        ];
    }
}