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
use Config;

class IngresoNoManifestadoController extends Controller
{
    public $username;
    public $password;
    public $camir;
    public $endpoint;
    private $cliente;
    private $trafico = 'A';

    public function __construct()
    {
        $this->username = Config::get('app.vucemsira.user');
        $this->password = Config::get('app.vucemsira.password');
        $this->camir = Config::get('app.vucemsira.camir');
        $this->$endpoint = Config::get('app.vucemsira.endpoint_ingresos');

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
        $validator = Validator::make($request->all(), [
            'consecutivo' => 'required',
            'idAsociado' => 'required',
            'tipoOperacion' => 'required',
            'fechaInicioDescarga' => 'required',
            'fechaFinDescarga' => 'required',
            'peso' => 'required',
            'condicionCarga' => 'required',
        ]);

        if ($validator->fails()) {
            $response = ['return'=>'error','mensaje'=>'Error al recibir los valores requeridos'];
            return response()->json($response, JSON_UNESCAPED_UNICODE );
        }

        $data =
            ['arg0'=>
                ['informacionGeneral' =>
                    [
                        //AQUI VA EL CONSECUTIVO GENERADO POR EL EMISOR DE LA TRANSMISION
                        'consecutivo'=>$request->consecutivo,
                        //AQUI VA EL ID ASOCIADO RECIBIDO EN LA NOTIFICACIÓN
                        'idAsociado'=>$request->idAsociado,
                        //AQUI VA LA FECHA ACTUAL FORMATO YYYY-MM-DDTHH:MM:SSZ
                        'fechaRegistro'=>gmdate('Y-m-d\TH:i:s\Z'),
                        //QUI VA SIEMPRE 4, CORRESPONDE AL INGRESO NO MANIFESTADO
                        'tipoMovimiento'=>'4',
                        //1= FERROS 2= AEREOS 3=MUM
                        'detalleMovimiento'=>'2',
                        //1= IMPORTACIÓN 2= EXPORTACIÓN
                        'tipoOperacion'=>$request->tipoOperacion,
                        //AQUI VA EL CAMIR DEL RECINTO
                        'cveRecintoFiscalizado'=>$this->camir,
                    ]
                ],
                ['informacionIngreso' =>
                    [
                        //AQUI VAN VALORES DE CATALOGO QUE ENVIA RF 1=3 DÍAS, 2=45 DÍAS, 3=60 DÍAS
                        'tipoMercancia'=>$request->tipoMercancia,
                        //AQUI VA EL FECHA EN QUE INICIA LA DESCARGA FORMATO YYYY-MM-DDTHH:MM:SSZ
                        'fechaInicioDescarga'=>$request->fechaInicioDescarga,
                        //AQUI VA EL FECHA EN QUE TERMINA LA DESCARGA FORMATO YYYY-MM-DDTHH:MM:SSZ
                        'fechaFinDescarga'=>$request->fechaFinDescarga,
                        //AQUÍ VA EL PESO EN KILOGRAMOS (30.5)
                        'peso'=>$request->peso,
                        //AQUÍ VA 1=CARGA EN OPTIMAS CONDICIONES, 2=CARGA MOJADA, 3=CARGA DAÑADA
                        'condicionCarga'=>$request->condicionCarga,
                        //AQUÍ VAN LOS DETALLES DEL INGRESO DE LA MERCANCÍA
                        'observaciones'=>$observaciones
                    ]
                ],
                ['transporte' =>
                    [
                        'numeroVueloBuqueViajeImo' => '',
                        'tipoTransporte' => 'A',
                        'fechaHoraDeArribo' => '',
                        'origenVueloBuque' => '',
                        'numeroManifiesto' => '',
                        'caat' => '',
                        'peso' => '',
                        'ump' => '',
                        'piezas' => ''
                    ]
                ],
                ['guiaMaster' =>
                    [
                        'numeroGuiaBl' => '',
                        'caat' => '',
                        'tipoOperacion' => '',
                        'peso' => '',
                        'ump' => '',
                        'volumen' => '',
                        'umv' => '',
                        'piezas' => '',
                        'idParcialidad' => '',
                        'secuencia' => '',
                        'observaciones'=>$observaciones
                    ]
                ]
            ];


    }
    /*end IngresoNoManifestado*/
}
