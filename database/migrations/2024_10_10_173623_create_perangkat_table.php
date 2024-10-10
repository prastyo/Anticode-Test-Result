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
        Schema::create('perangkat', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('penduduk_id')->index()->unsigned();
            $table->bigInteger('jabatan_id')->index()->unsigned();
            $table->bigInteger('nipd')->nullable();
            $table->bigInteger('nip')->nullable();
            $table->string('pangkat_golongan')->nullable();
            $table->bigInteger('no_keputusan_pengangkatan')->nullable();
            $table->date('tanggal_keputusan_pengangkatan')->nullable();
            $table->bigInteger('no_keputusan_pemberhentian')->nullable();
            $table->date('tanggal_keputusan_pemberhentian')->nullable();
            $table->string('status_pejabat'); //ENUM values : Aktif, Tidak Aktif;
            $table->string('masa_jabatan');
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
        Schema::dropIfExists('perangkat');
    }
};
