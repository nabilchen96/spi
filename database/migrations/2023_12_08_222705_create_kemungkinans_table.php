<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateKemungkinansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('kemungkinans', function (Blueprint $table) {
            $table->id();
            $table->string('id_profil_risiko');
            $table->integer('jumlah_kemungkinan');
            $table->integer('total_aktivitas');
            $table->string('frekuensi');
            $table->string('kejadian');
            $table->integer('level_kemungkinan');
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
        Schema::dropIfExists('kemungkinans');
    }
}
