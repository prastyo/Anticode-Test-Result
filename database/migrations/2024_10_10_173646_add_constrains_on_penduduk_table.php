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
        Schema::table('penduduk', function (Blueprint $table) {

            $table->foreign('agama_id')
                    ->references('id')
                    ->on('data_agama')
                    ->onUpdate('cascade')
                    ->onDelete('restrict');

            $table->foreign('hubungan_keluarga_id')
                    ->references('id')
                    ->on('data_hubungan_keluarga')
                    ->onUpdate('cascade')
                    ->onDelete('restrict');

            $table->foreign('pendidikan_id')
                    ->references('id')
                    ->on('data_pendidikan')
                    ->onUpdate('restrict')
                    ->onDelete('restrict');

            $table->foreign('kawin_id')
                    ->references('id')
                    ->on('data_kawin')
                    ->onUpdate('cascade')
                    ->onDelete('restrict');

            $table->foreign('akseptor_kb_id')
                    ->references('id')
                    ->on('data_akseptor_kb')
                    ->onUpdate('cascade')
                    ->onDelete('restrict');

            $table->foreign('pekerjaan_id')
                    ->references('id')
                    ->on('data_pekerjaan')
                    ->onUpdate('restrict')
                    ->onDelete('restrict');

            $table->foreign('sakit_menahun_id')
                    ->references('id')
                    ->on('data_sakit_menahun')
                    ->onUpdate('restrict')
                    ->onDelete('restrict');

            $table->foreign('cacat_id')
                    ->references('id')
                    ->on('data_cacat')
                    ->onUpdate('cascade')
                    ->onDelete('restrict');

            $table->foreign('golongan_darah_id')
                    ->references('id')
                    ->on('data_golongan_darah')
                    ->onUpdate('cascade')
                    ->onDelete('restrict');

            $table->foreign('warganegara_id')
                    ->references('id')
                    ->on('data_warganegara')
                    ->onUpdate('restrict')
                    ->onDelete('restrict');

            $table->foreign('asuransi_id')
                    ->references('id')
                    ->on('data_asuransi')
                    ->onUpdate('cascade')
                    ->onDelete('restrict');

            $table->foreign('status_dasar_id')
                    ->references('id')
                    ->on('data_status_dasar')
                    ->onUpdate('restrict')
                    ->onDelete('restrict');

            $table->foreign('suku_id')
                    ->references('id')
                    ->on('data_suku')
                    ->onUpdate('restrict')
                    ->onDelete('restrict');

            $table->foreign('kursus_id')
                    ->references('id')
                    ->on('data_kursus')
                    ->onUpdate('restrict')
                    ->onDelete('restrict');

            $table->foreign('bahasa_id')
                    ->references('id')
                    ->on('data_bahasa')
                    ->onUpdate('cascade')
                    ->onDelete('restrict');

            $table->foreign('created_by')
                    ->references('id')
                    ->on('users')
                    ->onUpdate('cascade')
                    ->onDelete('set null');

            $table->foreign('updated_by')
                    ->references('id')
                    ->on('users')
                    ->onUpdate('cascade')
                    ->onDelete('set null');

            $table->foreign('deleted_by')
                    ->references('id')
                    ->on('users')
                    ->onUpdate('cascade')
                    ->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
            Schema::dropForeign('agama_id');
            Schema::dropForeign('hubungan_keluarga_id');
            Schema::dropForeign('pendidikan_id');
            Schema::dropForeign('kawin_id');
            Schema::dropForeign('akseptor_kb_id');
            Schema::dropForeign('pekerjaan_id');
            Schema::dropForeign('sakit_menahun_id');
            Schema::dropForeign('cacat_id');
            Schema::dropForeign('golongan_darah_id');
            Schema::dropForeign('warganegara_id');
            Schema::dropForeign('asuransi_id');
            Schema::dropForeign('status_dasar_id');
            Schema::dropForeign('suku_id');
            Schema::dropForeign('kursus_id');
            Schema::dropForeign('bahasa_id');
            Schema::dropForeign('created_by');
            Schema::dropForeign('updated_by');
            Schema::dropForeign('deleted_by');
    }
};
