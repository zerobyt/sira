<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMercanciaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::dropIfExists('mercancia');    // Si existe la tabla la borra
        if(!Schema::hasTable('mercancia')){   // Si no existe la tabla la crea
          Schema::create('mercancia', function (Blueprint $table) {
             $table->bigIncrements('id');
             $table->timestamps();
             $table->softDeletes();
             $table->integer('secuencia')->nullable();
             $table->string('pais',256)->nullable();
             $table->text('descripcion')->nullable();
             $table->string('valor',256)->nullable();
             $table->string('moneda',256)->nullable();
             $table->string('cantidad',256)->nullable();
             $table->string('umc',256)->nullable();
             $table->string('peso',256)->nullable();
             $table->string('ump',256)->nullable();
             $table->string('volumen',256)->nullable();
             $table->text('observaciones')->nullable();
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
        Schema::dropIfExists('mercancia');
    }
}
