<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableRequests extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::dropIfExists('logdatarequest');    // Si existe la tabla la borra
        if(!Schema::hasTable('logdatarequest')){   // Si no existe la tabla la crea
            Schema::create('logdatarequest', function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->timestamps();
                $table->softDeletes();
                $table->string('consecutivo',256)->nullable();
                $table->string('idAsociado',256)->nullable();
                $table->string('tipo_request',256)->nullable();
                $table->longText('data_request')->nullable();
                $table->longText('data_response_json')->nullable();
                $table->longText('data_response_xml')->nullable();
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
        Schema::dropIfExists('logdatarequest');
    }
}
