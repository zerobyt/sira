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

class PersonasContenedor extends Model
{
    protected $table = 'personas_contenedor';
    public $timestamps = false;
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
        'idContenedor'
    ];
}
