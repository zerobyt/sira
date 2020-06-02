<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransporteTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::dropIfExists('transporte');    // Si existe la tabla la borra
        if(!Schema::hasTable('transporte')){   // Si no existe la tabla la crea
          Schema::create('transporte', function (Blueprint $table) {
             $table->bigIncrements('id');
             $table->timestamps();
             $table->softDeletes();
             $table->string('numeroVueloBuqueViajeImo',256)->nullable();
             $table->string('tipoTransporte',256)->nullable();
             $table->string('fechaHoraDeArribo',256)->nullable();
             $table->string('origenVueloBuque',256)->nullable();
             $table->string('numeroManifiesto',256)->nullable();
             $table->string('caat',256)->nullable();
             $table->string('peso',256)->nullable();
             $table->string('ump',256)->nullable();
             $table->string('piezas',256)->nullable();
             $table->bigInteger('idInfoGeneral')->unsigned()->nullable();
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
        Schema::dropIfExists('transporte');
    }
}
