<?php

/*
*  Webservice VUCEM/SIRA basado en Manual de Operación SIRA v3.7
*  Desarrollado por Cristian Omar Vega Mendoza.
*  para Interpuerto Multimodal de México S.A. de C.V.
*  queda estrictamente prohibida la reproducción total y/o parcial
*  con fines lucrativos.
*/

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LogDataRequest extends Model
{
    protected $table = 'logdatarequest';
    public $timestamps = true;
    protected $fillable = [
        'consecutivo',
        'idAsociado',
        'tipo_request',
        'data_request',
        'data_response_json',
        'data_response_xml'
    ];
}
