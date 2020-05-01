<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInstitucionesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('instituciones', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('id_contacto_usuario');
            $table->string('nombre_instituciones');
            $table->string('email_instituciones')->unique();
            $table->integer('id_ciudad');
            $table->string('celular_instituciones');
            $table->integer('telefono_instituciones');
            $table->string('direccion_instituciones');
            $table->string('avatar_instituciones');
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
        Schema::drop('instituciones');
    }
}
