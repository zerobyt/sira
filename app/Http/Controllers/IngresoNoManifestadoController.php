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

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use App\Helpers\nusoap_client;

class IngresoNoManifestadoController extends Controller
{
    private $username = "MAR870122MX9";
    private $password = "i1yzMzAa3RvVgMzNAmTnL0hvVmSRTYDOpmuTrO0+REFMnCTj+k+LFHmZRtgkMkEq";
    private $camir = '4718';
    private $trafico = 'A';
    PRIVATE $endpoint = 'https://201.151.252.116:9202/OperacionEntradaImpl/OperacionEntradaService';
    private $cliente;

    public function __construct()
    {
        // Seguridad
        $created = gmdate('Y-m-d\TH:i:s\Z');
        $expires = gmdate('Y-m-d\TH:i:s\Z', time() + 59);
        $header = "
        <wsse:Security
            xmlns:wsse='http://docs.oasis-open.org/wss/2004/01/oasis-200401-wss-wssecurity-secext-1.0.xsd'
            xmlns:wsu='http://docs.oasis-open.org/wss/2004/01/oasis-200401-wss-wssecurity-utility-1.0.xsd'>
            <wsse:UsernameToken>
                <wsse:Username>$this->username</wsse:Username>
                <!--Es el usuario definido por el SAT para el acceso a la VUCEM. Es del tamaño de un RFC (12 o 13 caracteres)-->
                <wsse:Password Type='http://docs.oasis-open.org/wss/2004/01/oasis-200401-wss-username-token-profile-1.0#PasswordText'>$this->password</wsse:Password>
            </wsse:UsernameToken >
            <wsu:Timestamp wsu:Id='Timestamp-5c9f0ef0-ab45-421d-a633-4c4fad26d945'>
                  <wsu:Created>$created</wsu:Created>
                  <wsu:Expires>$expires</wsu:Expires>
            </wsu:Timestamp>
            </wsse:Security>";
        $this->cliente = new nusoap_client($this->endpoint.'?wsdl','wsdl');
        $this->cliente->setEndpoint($this->endpoint);
        $this->cliente->setHeaders($header);
    }



    /*IngresoNoManifestado*/
    public function IngresoNoManifestado(Request $request)
    {

    }
    /*end IngresoNoManifestado*/
}
