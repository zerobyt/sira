<?php

/*
*  Webservice VUCEM/SIRA basado en Manual de Operación SIRA v3.7
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
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use App\Helpers\nusoap_client;
use Config;

class IngresoSimpleController extends Controller
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
        $this->endpoint = Config::get('app.vucemsira.endpoint_ingresos');

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

    /*IngresoSimple por Guía Master*/
    public function IngresoSimpleMaster(Request $request)
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
            $response = ['return'=>'error','mensajes'=>'Error al recibir los valores requeridos'];
            return response()->json($response, JSON_UNESCAPED_UNICODE );
        }

        $observaciones = isset($request->observaciones) ? $request->observaciones : 'INGRESO SIMPLE POR MASTER IMM RECINTO 262';

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
                        //QUI VA SIEMPRE 1, CORRESPONDE AL INGRESO SIMPLE
                        'tipoMovimiento'=>'1',
                        //1= FERROS 2= AEREOS 3=MUM
                        'detalleMovimiento'=>'2',
                        //1= IMPORTACIÓN 2= EXPORTACIÓN
                        'tipoOperacion'=>$request->tipoOperacion,
                        //AQUI VA EL CAMIR DEL RECINTO
                        'cveRecintoFiscalizado'=>$this->camir,
                        //AQUÍ VA M = MASTER EN ESTE CASO
                        'tipoIngreso'=>'M'
                    ]
                ,'informacionIngreso' =>
                    [
                        //AQUI VAN VALORES DE CATALOGO QUE ENVIA RF 1=3 DÍAS, 2=45 DÍAS, 3=60 DÍAS
                        'tipoMercancia'=>'',
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
                ]
            ];

            $call = $this->cliente->call('ingresoSimple',$data);
            return response()->json($call, JSON_UNESCAPED_UNICODE );
            //return response()->json($data, JSON_UNESCAPED_UNICODE);//Debuging Request
    }
    /*end IngresoSimple por Guía Master*/

    /*IngresoSimple por Guía House*/
    public function IngresoSimpleHouse(Request $request)
    {
        //Ejemplo de Request:
        //http://localhost/sira/IngresoSimple/House?tipoOperacion=1&guiasHouse=TRESABRIL27%2CCUATROABRIL27%2CCINCOABRIL27&consecutivo=20000006Q&idAsociado=20000006Q&fechaInicioDescarga=2020-08-14T09%3A11%3A32-05%3A00&fechaFinDescarga=2020-08-14T09%3A50%3A00-05%3A00&peso=301.0&condicionCarga=1
        $validator = Validator::make($request->all(), [
            'consecutivo' => 'required',
            'idAsociado' => 'required',
            'tipoOperacion' => 'required',
            'fechaInicioDescarga' => 'required',
            'fechaFinDescarga' => 'required',
            'peso' => 'required',
            'condicionCarga' => 'required',
            'guiasHouse' => 'required',
        ]);

        if ($validator->fails()) {
            $response = ['return'=>'error','mensajes'=>'Error al recibir los valores requeridos'];
            return response()->json($response, JSON_UNESCAPED_UNICODE );
        }

        $ArrayHouses = [];
        $guiasHouse = explode(',', $request->guiasHouse);
        for($i=0;$i<count($guiasHouse);$i++){
            $ArrayHouses['guiasHouse'][] = ['guiaHouse'=>$guiasHouse[$i]];
        }

        $observaciones = isset($request->observaciones) ? $request->observaciones : 'INGRESO SIMPLE POR HOUSE IMM RECINTO 262';

        $informacionGeneral = ['informacionGeneral' =>
                    [
                        //AQUI VA EL CONSECUTIVO GENERADO POR EL EMISOR DE LA TRANSMISION
                        'consecutivo'=>$request->consecutivo,
                        //AQUI VA EL ID ASOCIADO RECIBIDO EN LA NOTIFICACIÓN
                        'idAsociado'=>$request->idAsociado,
                        //AQUI VA LA FECHA ACTUAL FORMATO YYYY-MM-DDTHH:MM:SSZ
                        'fechaRegistro'=>gmdate('Y-m-d\TH:i:s\Z'),
                        //QUI VA SIEMPRE 1, CORRESPONDE AL INGRESO SIMPLE
                        'tipoMovimiento'=>'1',
                        //1= FERROS 2= AEREOS 3=MUM
                        'detalleMovimiento'=>'2',
                        //1= IMPORTACIÓN 2= EXPORTACIÓN
                        'tipoOperacion'=>$request->tipoOperacion,
                        //AQUI VA EL CAMIR DEL RECINTO
                        'cveRecintoFiscalizado'=>$this->camir,
                        //AQUÍ VA H = HOUSE EN ESTE CASO
                        'tipoIngreso'=>'H'
                    ]
                ];
        $informacionIngreso = ['informacionIngreso' =>
                    [
                        //AQUI VAN VALORES DE CATALOGO QUE ENVIA RF 1=3 DÍAS, 2=45 DÍAS, 3=60 DÍAS
                        'tipoMercancia'=>'',
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
                ];

        $merge_request = array_merge(
                $informacionGeneral,
                $informacionIngreso,
                $ArrayHouses
        );

        $data = ['arg0'=>$merge_request];


        //$call = $this->cliente->call('ingresoSimple',$data);
        //return response()->json($call, JSON_UNESCAPED_UNICODE );
        return response()->json($data, JSON_UNESCAPED_UNICODE);//Debuging Request
    }
    /*end IngresoSimple por Guía House*/
}
