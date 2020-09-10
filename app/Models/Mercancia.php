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

class Mercancia extends Model
{
    protected $table = 'mercancia';
    public $timestamps = true;
    public $hidden = ['id','created_at','updated_at','deleted_at','idGuia'];
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

    public function Guia()
    {
        return $this->belongsTo(Guia::class,'idGuia');
    }

    public function Vin()
    {
        return $this->hasMany(Vin::class);
    }

    public function Imo()
    {
        return $this->hasMany(Imo::class);
    }
}
