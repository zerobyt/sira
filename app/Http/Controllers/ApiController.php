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
    public function verGuiasMaster(Request $request)
    {
        $guias = Guia::where('tipoGuia','M')->get();
        return response()->json($guias, JSON_UNESCAPED_UNICODE );
    }
}
