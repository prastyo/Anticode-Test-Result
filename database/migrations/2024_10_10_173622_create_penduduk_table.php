<?php
/**
 * Budi Prastyo <budi@prastyo.com>
 * created_at : 2024-10-10 17:36:08
 */

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('penduduk', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->bigInteger('nik')->unique();
            $table->string('tempat_lahir');
            $table->date('tanggal_lahir');
            $table->string('jenis_kelamin'); //ENUM values : Laki-laki, Perempuan;
            $table->bigInteger('agama_id')->index()->unsigned();
            $table->string('telepon')->nullable();
            $table->string('email')->unique()->nullable();
            $table->string('identitas_elektronik'); //ENUM values : Belum, KTP_EL, KIA;
            $table->bigInteger('hubungan_keluarga_id')->index()->unsigned();
            $table->bigInteger('rt');
            $table->bigInteger('rw');
            $table->string('alamat');
            $table->bigInteger('kodepos')->nullable();
            $table->bigInteger('pendidikan_id')->index()->unsigned();
            $table->bigInteger('nik_ayah')->nullable();
            $table->string('nama_ayah')->nullable();
            $table->bigInteger('nik_ibu')->nullable();
            $table->string('nama_ibu')->nullable();
            $table->string('akte_kelahiran'); //ENUM values : Ada, Tidak Ada;
            $table->bigInteger('kawin_id')->index()->unsigned();
            $table->bigInteger('akseptor_kb_id')->index()->unsigned();
            $table->bigInteger('pekerjaan_id')->index()->unsigned();
            $table->bigInteger('sakit_menahun_id')->index()->unsigned();
            $table->bigInteger('cacat_id')->index()->unsigned();
            $table->string('kelainan_fisik_mental'); //ENUM values : Tidak Ada, Ada;
            $table->bigInteger('golongan_darah_id')->index()->unsigned();
            $table->bigInteger('warganegara_id')->index()->unsigned();
            $table->bigInteger('asuransi_id')->index()->unsigned();
            $table->string('status_penduduk'); //ENUM values : Tetap, Tidak Tetap;
            $table->bigInteger('status_dasar_id')->index()->unsigned();
            $table->bigInteger('suku_id')->index()->unsigned()->nullable();
            $table->bigInteger('kursus_id')->index()->unsigned()->nullable();
            $table->bigInteger('bahasa_id')->index()->unsigned()->nullable();
            $table->bigInteger('created_by')->unsigned()->nullable();
            $table->bigInteger('updated_by')->unsigned()->nullable();
            $table->bigInteger('deleted_by')->unsigned()->nullable();
            $table->timestamps();            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('penduduk');
    }
};
