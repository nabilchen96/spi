<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRisikosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('risikos', function (Blueprint $table) {
            $table->id();
            $table->text('proses_bisnis');
            $table->text('identifikasi_risiko');
            $table->string('pengelola_risiko');
            $table->string('kategori_risiko');
            $table->string('uraian');
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
        Schema::dropIfExists('risikos');
    }
}
