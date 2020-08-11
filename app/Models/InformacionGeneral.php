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

use App\Models\Guia;

class InformacionGeneral extends Model
{
    protected $table = 'informaciongeneral';
    public $timestamps = true;
    protected $fillable = [
        'consecutivo',
        'idAsociado',
        'fechaRegistro',
        'tipoMovimiento',
        'detalleMovimiento',
        'tipoOperacion',
        'cveRecintoFiscalizado'
    ];

    public function Guias()
    {
        return $this->hasMany(Guia::class,'idInfoGeneral');
    }
}
