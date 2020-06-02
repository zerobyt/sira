<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInformaciongeneralTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::dropIfExists('informaciongeneral');    // Si existe la tabla la borra
        if(!Schema::hasTable('informaciongeneral')){   // Si no existe la tabla la crea
          Schema::create('informaciongeneral', function (Blueprint $table) {
             $table->bigIncrements('id');
             $table->timestamps();
             $table->softDeletes();
             $table->string('consecutivo',256)->nullable();
             $table->string('idAsociado',256)->nullable();
             $table->string('fechaRegistro',256)->nullable();
             $table->integer('tipoMovimiento')->nullable();
             $table->integer('detalleMovimiento')->nullable();
             $table->integer('tipoOperacion')->nullable();
             $table->string('cveRecintoFiscalizado',256)->nullable();
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
        Schema::dropIfExists('informaciongeneral');
    }
}
