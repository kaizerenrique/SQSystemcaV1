<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('historials', function (Blueprint $table) {
            $table->id();
            $table->integer('persona_id')->index();
            $table->string('nombreyapellido',200);
            $table->string('cedula',12)->nullable();
            $table->string('codigo',8);//codigo del usuario
            $table->string('nombreArchivo',120);
            $table->string('url_simbol', 2048)->nullable();
            $table->string('url_code', 21)->nullable();
            $table->string('url_documento', 2048)->nullable();
            $table->integer('user_id');// id de laboratorio
            $table->string('nombreLaboratorio',250);//laboratorio
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
        Schema::dropIfExists('historials');
    }
};
