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

class Personas extends Model
{
    protected $table = 'personas';
    public $timestamps = true;
    public $hidden = ['id','created_at','updated_at','deleted_at','idGuia'];
    protected $fillable = [
        'tipoPersona',
        'nombre',
        'calleDomicilio',
        'numeroInterior',
        'numeroExterior',
        'cp',
        'municipio',
        'entidadFederativa',
        'pais',
        'rfcOTaxid',
        'correoElectronico',
        'ciudad',
        'contacto',
        'telefono',
        'correoContacto',
        'idGuia'
    ];

    public function Guia()
    {
        return $this->belongsTo(Guia::class,'idGuia');
    }
}
