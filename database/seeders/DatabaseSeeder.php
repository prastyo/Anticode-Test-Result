<?php
/**
 * Budi Prastyo <budi@prastyo.com>
 * created_at : 2024-10-10 17:36:08
 */

namespace Database\Seeders;

use App\Models\DataSuku;
use App\Models\Keuangan;
use App\Models\Penduduk;
use App\Models\DataAgama;
use App\Models\DataCacat;
use App\Models\DataKawin;
use App\Models\DataKursu;
use App\Models\Kelahiran;
use App\Models\Perangkat;
use App\Models\DataBahasa;
use App\Models\DataJabatan;
use App\Models\DataAsuransi;
use App\Models\DataPekerjaan;
use App\Models\DataAkseptorKb;
use App\Models\DataPendidikan;
use Illuminate\Database\Seeder;
use App\Models\DataStatusDasar;
use App\Models\DataWarganegara;
use App\Models\DataSakitMenahun;
use Illuminate\Events\Dispatcher;
use App\Models\DataGolonganDarah;
use App\Models\DataJenisPersalinan;
use App\Models\DataHubunganKeluarga;
use App\Models\DataTempatDilahirkan;
use App\Models\DataPenolongKelahiran;
use Illuminate\Database\Eloquent\Model;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->call([
            UserSeeder::class,
        ]);

        /**
         * Many hours were invested in this code... may it finally work in peace!
         * 
         * The order is from models without foreign keys,
         * followed by models with foreign keys, where the position of the related models has been written earlier.
         * If the positions are swapped, the data will fail to be saved.
         */

        Model::unsetEventDispatcher(); // Disable all events temporarily so that created_by can be saved.

        Keuangan::factory(10)->create();
        DataWarganegara::factory(10)->create();
        DataTempatDilahirkan::factory(10)->create();
        DataSuku::factory(10)->create();
        DataStatusDasar::factory(10)->create();
        DataSakitMenahun::factory(10)->create();
        DataPenolongKelahiran::factory(10)->create();
        DataPendidikan::factory(10)->create();
        DataPekerjaan::factory(10)->create();
        DataKursu::factory(10)->create();
        DataKawin::factory(10)->create();
        DataJenisPersalinan::factory(10)->create();
        DataJabatan::factory(10)->create();
        DataHubunganKeluarga::factory(10)->create();
        DataGolonganDarah::factory(10)->create();
        DataCacat::factory(10)->create();
        DataBahasa::factory(10)->create();
        DataAsuransi::factory(10)->create();
        DataAkseptorKb::factory(10)->create();
        DataAgama::factory(10)->create();
        Penduduk::factory(10)->create();
        Kelahiran::factory(10)->create();
        Perangkat::factory(10)->create();

        Model::setEventDispatcher(new Dispatcher()); // Re-enable the event
    }
}