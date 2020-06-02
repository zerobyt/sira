<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVinTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::dropIfExists('vin');    // Si existe la tabla la borra
        if(!Schema::hasTable('vin')){   // Si no existe la tabla la crea
          Schema::create('vin', function (Blueprint $table) {
             $table->bigIncrements('id');
             $table->timestamps();
             $table->softDeletes();
             $table->string('vin',256)->nullable();
             $table->bigInteger('idMercancia')->unsigned()->nullable();
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
        Schema::dropIfExists('vin');
    }
}
