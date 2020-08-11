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
use Illuminate\Database\Eloquent\SoftDeletes;

use App\Models\InformacionGeneral;

class Guia extends Model
{
    use SoftDeletes;
    protected $table = 'guia';
    public $timestamps = true;
    protected $dates = ['deleted_at'];
    protected $fillable = [
        'numeroGuiaBl',
        'caat',
        'tipoOperacion',
        'valorDeclarado',
        'moneda',
        'peso',
        'ump',
        'volumen',
        'umv',
        'piezas',
        'idParcialidad',
        'secuencia',
        'observaciones',
        'tipoGuia',
        'idMaster',
        'idInfoGeneral'
    ];

    public function InformacionGeneral()
    {
        return $this->belongsTo(InformacionGeneral::class,'idInfoGeneral');
    }
}
