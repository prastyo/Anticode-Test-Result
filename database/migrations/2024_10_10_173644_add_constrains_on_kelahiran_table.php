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
        Schema::table('kelahiran', function (Blueprint $table) {

            $table->foreign('ayah_id')
                    ->references('id')
                    ->on('penduduk')
                    ->onUpdate('cascade')
                    ->onDelete('restrict');

            $table->foreign('ibu_id')
                    ->references('id')
                    ->on('penduduk')
                    ->onUpdate('cascade')
                    ->onDelete('restrict');

            $table->foreign('jenis_persalinan_id')
                    ->references('id')
                    ->on('data_jenis_persalinan')
                    ->onUpdate('cascade')
                    ->onDelete('restrict');

            $table->foreign('tempat_dilahirkan_id')
                    ->references('id')
                    ->on('data_tempat_dilahirkan')
                    ->onUpdate('cascade')
                    ->onDelete('restrict');

            $table->foreign('penolong_kelahiran_id')
                    ->references('id')
                    ->on('data_penolong_kelahiran')
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
            Schema::dropForeign('ayah_id');
            Schema::dropForeign('ibu_id');
            Schema::dropForeign('jenis_persalinan_id');
            Schema::dropForeign('tempat_dilahirkan_id');
            Schema::dropForeign('penolong_kelahiran_id');
            Schema::dropForeign('created_by');
            Schema::dropForeign('updated_by');
            Schema::dropForeign('deleted_by');
    }
};
