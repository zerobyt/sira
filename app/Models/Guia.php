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
use Illuminate\Database\Eloquent\SoftDeletes;

use App\Models\InformacionGeneral;

class Guia extends Model
{
    use SoftDeletes;
    protected $table = 'guia';
    public $timestamps = true;
    protected $dates = ['deleted_at'];
    public $hidden = ['id','created_at','updated_at','deleted_at','idInfoGeneral','idMaster'];
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

    public function Mercancia()
    {
        return $this->hasMany(Mercancia::class,'idGuia');
    }

    public function Personas()
    {
        return $this->hasMany(Personas::class,'idGuia');
    }

    public function Vin()
    {
        return $this->hasManyThrough(
            'App\Models\Vin',
            'App\Models\Mercancia',
            'idGuia',
            'idMercancia',
            'id',
            'id'
        );
    }

    public function Imo()
    {
        return $this->hasManyThrough(
            'App\Models\Imo',
            'App\Models\Mercancia',
            'idGuia',
            'idMercancia',
            'id',
            'id'
        );
    }

}
