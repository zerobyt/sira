<?php

/*
*  Webservice VUCEM/SIRA basado en Manual de Operación SIRA v3.5
*  Desarrollado por Cristian Omar Vega Mendoza.
*/

namespace App\Http\Controllers;

use App\Models\Guia;
use App\Models\InformacionGeneral;
use App\Models\Mercancia;
use App\Models\Personas;
use App\Models\Transporte;
use App\Models\Vin;
use App\Models\Imo;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;

class ApiController extends Controller
{
    public function getAllNotificaciones()
    {
        $informacionGeneral = InformacionGeneral::orderBy('id', 'DESC')->get();
        foreach($informacionGeneral as $infoGeneral){

            $transporte = Transporte::find($infoGeneral->id);
            $guiaMaster = Guia::Where('idInfoGeneral', $infoGeneral->id)->Where('tipoGuia','M')->with(['Mercancia','Personas','Vin','Imo'])->first();
            $guiasHouse = Guia::WhereNotNull('idMaster')->Where('idMaster', $guiaMaster->id)->Where('tipoGuia','H')->with(['Mercancia','Personas','Vin','Imo'])->get();

            $guiaMaster->guiasHouse = $guiasHouse;

            $notificacion[] =
                [
                    'informacionGeneral'=> $infoGeneral,
                    'transporte'=>$transporte,
                    'guiaMaster'=>$guiaMaster,
                ];

        }

        return response()->json($notificacion,200,[],JSON_PRETTY_PRINT);
    }
}
