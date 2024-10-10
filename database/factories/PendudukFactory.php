<?php
/**
 * Budi Prastyo <budi@prastyo.com>
 * created_at : 2024-10-10 17:36:08
 */

namespace Database\Factories;

use App\Models\User;
use App\Models\DataSuku;
use App\Models\DataAgama;
use App\Models\DataCacat;
use App\Models\DataKawin;
use App\Models\DataKursu;
use App\Models\DataBahasa;
use App\Models\DataAsuransi;
use App\Models\DataPekerjaan;
use App\Models\DataAkseptorKb;
use App\Models\DataPendidikan;
use App\Enums\JenisKelaminEnum;
use App\Models\DataStatusDasar;
use App\Models\DataWarganegara;
use App\Enums\AkteKelahiranEnum;
use App\Models\DataSakitMenahun;
use App\Enums\StatusPendudukEnum;
use App\Models\DataGolonganDarah;
use App\Models\DataHubunganKeluarga;
use App\Enums\IdentitasElektronikEnum;
use App\Enums\KelainanFisikMentalEnum;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class PendudukFactory extends Factory
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
            'nik'                      => fake()->nik(),
            'nik_ayah'                 => fake()->nik(),
            'nik_ibu'                  => fake()->nik(),
            'tempat_lahir'             => fake()->city(),
            'nama'                     => fake()->name(), // fake()->unique()->words(2, true),
            'nama_ayah'                => fake()->name(), // fake()->unique()->words(2, true),
            'nama_ibu'                 => fake()->name(), // fake()->unique()->words(2, true),
            'alamat'                   => fake()->address(),
            'kodepos'                  => fake()->postcode(),
            'telepon'                  => fake()->phoneNumber(),
            'tanggal_lahir'            => fake()->date('d-m-Y'), // in the model Penduduk that uses the d-m-Y format,
            'email'                    => fake()->unique()->safeEmail(), // Generate a safe email address,
            'rt'                       => fake()->randomNumber(9, true), // When the parameter is true, it will only return integers with a specific number of digits,
            'rw'                       => fake()->randomNumber(9, true), // When the parameter is true, it will only return integers with a specific number of digits,
            'created_by'               => User::inRandomOrder()->first(),
            'suku_id'                  => DataSuku::inRandomOrder()->first(),
            'agama_id'                 => DataAgama::inRandomOrder()->first(),
            'kawin_id'                 => DataKawin::inRandomOrder()->first(),
            'cacat_id'                 => DataCacat::inRandomOrder()->first(),
            'kursus_id'                => DataKursu::inRandomOrder()->first(),
            'bahasa_id'                => DataBahasa::inRandomOrder()->first(),
            'asuransi_id'              => DataAsuransi::inRandomOrder()->first(),
            'pekerjaan_id'             => DataPekerjaan::inRandomOrder()->first(),
            'pendidikan_id'            => DataPendidikan::inRandomOrder()->first(),
            'akseptor_kb_id'           => DataAkseptorKb::inRandomOrder()->first(),
            'warganegara_id'           => DataWarganegara::inRandomOrder()->first(),
            'status_dasar_id'          => DataStatusDasar::inRandomOrder()->first(),
            'sakit_menahun_id'         => DataSakitMenahun::inRandomOrder()->first(),
            'golongan_darah_id'        => DataGolonganDarah::inRandomOrder()->first(),
            'hubungan_keluarga_id'     => DataHubunganKeluarga::inRandomOrder()->first(),
            'jenis_kelamin'            => fake()->randomElement(JenisKelaminEnum::cases())->value,
            'akte_kelahiran'           => fake()->randomElement(AkteKelahiranEnum::cases())->value,
            'status_penduduk'          => fake()->randomElement(StatusPendudukEnum::cases())->value,
            'identitas_elektronik'     => fake()->randomElement(IdentitasElektronikEnum::cases())->value,
            'kelainan_fisik_mental'    => fake()->randomElement(KelainanFisikMentalEnum::cases())->value
        ];
    }
}