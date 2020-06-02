<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePersonasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::dropIfExists('personas');    // Si existe la tabla la borra
        if(!Schema::hasTable('personas')){   // Si no existe la tabla la crea
          Schema::create('personas', function (Blueprint $table) {
             $table->bigIncrements('id');
             $table->timestamps();
             $table->softDeletes();
             $table->string('tipoPersona',256)->nullable();
             $table->string('nombre',256)->nullable();
             $table->string('calleDomicilio',256)->nullable();
             $table->string('numeroInterior',256)->nullable();
             $table->string('numeroExterior',256)->nullable();
             $table->string('cp',256)->nullable();
             $table->string('municipio',256)->nullable();
             $table->string('entidadFederativa',256)->nullable();
             $table->string('pais',256)->nullable();
             $table->string('rfcOTaxId',256)->nullable();
             $table->string('correoElectronico',256)->nullable();
             $table->string('ciudad',256)->nullable();
             $table->string('contacto',256)->nullable();
             $table->string('telefono',256)->nullable();
             $table->string('correoContacto',256)->nullable();
             $table->bigInteger('idGuia')->unsigned()->nullable();
          });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('personas');
    }
}
