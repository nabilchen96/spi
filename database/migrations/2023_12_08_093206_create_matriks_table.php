<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMatriksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('matriks', function (Blueprint $table) {
            $table->id();
            $table->string('tingkat_dampak');
            $table->string('tingkat_frekuensi');
            $table->integer('nilai_matrik');
            $table->string('level_risiko');
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
        Schema::dropIfExists('matriks');
    }
}
