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

class Mercancia extends Model
{
    protected $table = 'mercancia';
    public $timestamps = true;
    protected $fillable = [
        'secuencia',
        'pais',
        'descripcion',
        'valor',
        'moneda',
        'cantidad',
        'umc',
        'peso',
        'ump',
        'volumen',
        'observaciones',
        'idGuia'
    ];
}
