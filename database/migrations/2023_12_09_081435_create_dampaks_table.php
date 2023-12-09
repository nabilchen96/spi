<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDampaksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dampaks', function (Blueprint $table) {
            $table->id();
            $table->string('id_profil_risiko');
            $table->string('beban_keuangan_negara');
            $table->string('penurunan_reputasi');
            $table->string('dampak_hukum');
            $table->string('sasaran_kinerja');
            $table->string('keselamatan_transportasi');
            $table->integer('kriteria_dampak');
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
        Schema::dropIfExists('dampaks');
    }
}
