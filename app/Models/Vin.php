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

class Vin extends Model
{
    protected $table = 'vin';
    public $timestamps = true;
    public $hidden = ['id','created_at','updated_at','deleted_at','idMercancia','laravel_through_key'];
    protected $fillable = [
        'vin',
        'idMercancia'
    ];

    public function Mercancia()
    {
        return $this->belongsTo(Mercancia::class,'idMercancia');
    }
}
