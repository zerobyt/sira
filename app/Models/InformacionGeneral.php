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

use App\Models\Guia;

class InformacionGeneral extends Model
{
    protected $table = 'informaciongeneral';
    public $timestamps = true;
    public $hidden = ['updated_at','deleted_at'];
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
