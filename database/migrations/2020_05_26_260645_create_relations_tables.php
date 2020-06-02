<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRelationsTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('transporte', function (Blueprint $table) {
            $table->foreign('idInfoGeneral')->references('id')->on('informaciongeneral');
        });
        Schema::table('guia', function (Blueprint $table) {
            $table->foreign('idInfoGeneral')->references('id')->on('informaciongeneral');
        });
        Schema::table('mercancia', function (Blueprint $table) {
            $table->foreign('idGuia')->references('id')->on('guia');
        });
        Schema::table('imo', function (Blueprint $table) {
            $table->foreign('idMercancia')->references('id')->on('mercancia');
        });
        Schema::table('vin', function (Blueprint $table) {
            $table->foreign('idMercancia')->references('id')->on('mercancia');
        });
        Schema::table('personas', function (Blueprint $table) {
            $table->foreign('idGuia')->references('id')->on('guia');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
    }
}
