<?php

/*
*  Webservice VUCEM/SIRA basado en Manual de Operación SIRA v3.5
*  Desarrollado por Cristian Omar Vega Mendoza.
*  para Interpuerto Multimodal de México S.A. de C.V.
*  queda estrictamente prohibida la reproducción total y/o parcial
*  con fines lucrativos.
*/

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transporte extends Model
{
    protected $table = 'transporte';
    public $timestamps = true;
    protected $fillable = [
        'numeroVueloBuqueViajeImo',
        'tipoTransporte',
        'fechaHoraDeArribo',
        'origenVueloBuque',
        'numeroManifiesto',
        'caat',
        'peso',
        'ump',
        'piezas'
    ];
}
