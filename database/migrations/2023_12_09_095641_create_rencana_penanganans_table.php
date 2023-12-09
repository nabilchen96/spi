<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRencanaPenanganansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rencana_penanganans', function (Blueprint $table) {
            $table->id();
            $table->string('id_profil_risiko');
            $table->string('opsi_penanganan');
            $table->string('penanganan_lain');
            $table->integer('jumlah_kegiatan');
            $table->date('jadwal');
            $table->integer('level_kemungkinan');
            $table->integer('level_dampak');
            $table->integer('nilai_risiko');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('rencana_penanganans');
    }
}
