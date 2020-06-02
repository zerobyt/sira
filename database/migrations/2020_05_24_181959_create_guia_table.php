<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGuiaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::dropIfExists('guia');    // Si existe la tabla la borra
        if(!Schema::hasTable('guia')){   // Si no existe la tabla la crea
          Schema::create('guia', function (Blueprint $table) {
             $table->bigIncrements('id');
             $table->timestamps();
             $table->softDeletes();
             $table->string('numeroGuiaBl',256)->nullable();
             $table->string('caat',256)->nullable();
             $table->integer('tipoOperacion')->nullable();
             $table->string('valorDeclarado',256)->nullable();
             $table->string('moneda',256)->nullable();
             $table->string('peso',256)->nullable();
             $table->string('ump',256)->nullable();
             $table->string('volumen',256)->nullable();
             $table->string('umv',256)->nullable();
             $table->string('piezas',256)->nullable();
             $table->string('idParcialidad',256)->nullable();
             $table->integer('secuencia')->nullable();
             $table->text('observaciones')->nullable();
             $table->string('tipoGuia',256)->nullable();
             $table->bigInteger('idMaster')->nullable();
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
        Schema::dropIfExists('guia');
    }
}
