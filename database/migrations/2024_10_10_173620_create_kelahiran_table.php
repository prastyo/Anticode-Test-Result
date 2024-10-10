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
        Schema::create('kelahiran', function (Blueprint $table) {
            $table->id();
            $table->string('nama_anak');
            $table->string('jenis_kelamin'); //ENUM values : Laki-laki, Perempuan;
            $table->bigInteger('ayah_id')->index()->unsigned()->nullable();
            $table->bigInteger('ibu_id')->index()->unsigned()->nullable();
            $table->string('hari_lahir');
            $table->string('tempat_lahir');
            $table->date('tanggal_lahir');
            $table->time('jam_lahir');
            $table->bigInteger('jenis_persalinan_id')->index()->unsigned();
            $table->integer('anak_ke');
            $table->integer('berat_bayi');
            $table->integer('panjang_bayi');
            $table->bigInteger('tempat_dilahirkan_id')->index()->unsigned();
            $table->bigInteger('penolong_kelahiran_id')->index()->unsigned();
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
        Schema::dropIfExists('kelahiran');
    }
};
