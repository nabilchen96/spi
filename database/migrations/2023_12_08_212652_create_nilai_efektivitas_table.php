<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNilaiEfektivitasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('nilai_efektivitas', function (Blueprint $table) {
            $table->id();
            $table->string('id_profil_risiko');
            $table->integer('nilai_a');
            $table->integer('nilai_b');
            $table->integer('nilai_c');
            $table->integer('jumlah');
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
        Schema::dropIfExists('nilai_efektivitas');
    }
}
