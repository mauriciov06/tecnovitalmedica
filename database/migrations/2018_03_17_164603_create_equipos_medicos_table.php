<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEquiposMedicosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('equipos_medicos', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('id_instituciones');
            $table->string('nombre_equipo_medico');
            $table->string('marca');
            $table->string('modelo');
            $table->string('activo_fijo');
            $table->string('serie');
            $table->string('ubicacion');
            $table->string('url_imagen_equipo');
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
        Schema::drop('equipos_medicos');
    }
}
