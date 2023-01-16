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
use App\Models\LogDataRequest;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;
//use App\Helpers\nusoap_client;
use nusoap_client;
use Config;
use Spatie\ArrayToXml\ArrayToXml;

class IngresoParcialController extends Controller
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

    /*IngresoParcial por Guía Master*/
    public function IngresoParcialMaster(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'consecutivo' => 'required',
            'idAsociado' => 'required',
            'tipoOperacion' => 'required',
            'tipoMercancia' => 'required',
            'fechaInicioDescarga' => 'required',
            'fechaFinDescarga' => 'required',
            'peso' => 'required',
            'numeroParcialidad' => 'required',
            'cantidad' => 'required',
            'condicionCarga' => 'required',
        ]);

        if ($validator->fails()) {
            $response = ['return'=>'error','mensajes'=>'Error al recibir los valores requeridos'];
            return response()->json($response);
        }

        $observaciones = isset($request->observaciones) ? $request->observaciones : 'INGRESO SIMPLE POR MASTER IMM RECINTO 262';
        $vins = isset($request->vins) ? $request->vins : [];

        $data = ['arg0'=>
                    ['informacionGeneral' =>
                        [
                            //AQUI VA EL CONSECUTIVO GENERADO POR EL EMISOR DE LA TRANSMISION
                            'consecutivo'=>$request->consecutivo,
                            //AQUI VA EL ID ASOCIADO RECIBIDO EN LA NOTIFICACIÓN
                            'idAsociado'=>$request->idAsociado,
                            //AQUI VA LA FECHA ACTUAL
                            'fechaRegistro'=>gmdate('Y-m-d\TH:i:s\Z'),
                            //AQUI VA EL TIPO DE MOVIMIENTO SIEMPRE 3 PARA INGRESO PARCIAL
                            'tipoMovimiento' => '3',
                            //1= FERROS 2= AEREOS 3=MUM
                            'detalleMovimiento'=>'2',
                            //1= IMPORTACIÓN 2= EXPORTACIÓN
                            'tipoOperacion'=>$request->tipoOperacion,
                            //AQUI VA EL CAMIR
                            'cveRecintoFiscalizado'=>$this->camir,
                            //AQUÍ VA M = MASTER EN ESTE CASO
                            'tipoIngreso'=>'M'
                        ]
                    ],
                    ['informacionIngresoParcial'=>
                        [
                            //ESTADIA EN EL RECINTO (1,3,5....DIAS)
                            'tipoMercancia'=>$request->tipoMercancia,
                            //FECHA EN LA QUE SE INCIO LA DESCARGA DE LA MERCANCIA EN EL RECINTO
                            'fechaInicioDescarga'=>$request->fechaInicioDescarga,
                            //FECHA EN LA QUE SE TERMINO LA DESCARGA DE LA MERCANCIA EN EL RECINTO
                            'fechaFinDescarga'=>$request->fechaFinDescarga,
                            //PESO DE LA MERCANCIA EN KG QUE SE VA A INGRESAR
                            'peso' => $request->peso,
                            //NUMERO DE LA PARCIALIDAD DEBE SER UN NUMERO CONSECUTIVO Y RESPETAR EL ORDEN SEGUN LAS PARCIALIDADES A INGRESAR
                            'numeroParcialidad'=> $request->numeroParcialidad,
                            //CANTIDAD DE PIEZAS
                            'cantidad'=> $request->cantidad,
                            //UNIDAD DE MEDIDA DE CANTIDAD
                            'umc'=>'PCS',
                            //1:OPTIMAS CONDICIONES, 2:CARGA MOJADA, 3:CARGA DAÑADA
                            'condicionCarga'=> $request->condicionCarga,
                            //OBSERVACIONES SOBRE LA MERCANCIA INGRESADA
                            'observaciones'=> $observaciones,
                            //SI HAY VINS EN LA PARCIALIDAD SE DEFINE EL SEGMENTO SINO SOLO SE DECLARA <vin>NUMERO_VIN</vin>
                            'vins'=>$request->vins,
                        ]
                    ]
                ];

                //Retorna el arrayObject directo del WS de VUCEM
                $call = $this->cliente->call('ingresoParcial',$data);
                $response = json_encode($call,200,[], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_INVALID_UTF8_IGNORE);

                //Guardando request en base de datos
                $LogData = new LogDataRequest;
                $LogData->consecutivo = $request->consecutivo;
                $LogData->idAsociado = $request->idAsociado;
                $LogData->tipo_request = 'ingresoParcialMaster';
                $LogData->data_request = json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_INVALID_UTF8_IGNORE);
                $LogData->data_response_json = $response;
                $LogData->data_response_xml = ArrayToXml::convert($call);
                $LogData->save();

                return response($response);
    }
    /*end IngresoParcial por Guía Master*/

    /*Ingreso Parcial por Guía House*/
    public function IngresoParcialHouse(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'consecutivo' => 'required',
            'idAsociado' => 'required',
            'tipoOperacion' => 'required',
            'guiaHouse' => 'required',
            'fechaInicioDescarga' => 'required',
            'fechaFinDescarga' => 'required',
            'numeroParcialidad' => 'required',
            'peso' => 'required',
            'cantidad' => 'required',
            'condicionCarga' => 'required',
        ]);

        if ($validator->fails()) {
            $response = ['return'=>'error','mensajes'=>'Error al recibir los valores requeridos'];
            return response()->json($response, JSON_UNESCAPED_UNICODE );
        }

        $observaciones = isset($request->observaciones) ? $request->observaciones : 'INGRESO SIMPLE POR MASTER IMM RECINTO 262';

        $data = ['arg0'=>
                    ['informacionGeneral' =>
                        [
                            //AQUI VA EL CONSECUTIVO GENERADO POR EL EMISOR DE LA TRANSMISION
                            'consecutivo'=>$request->consecutivo,
                            //AQUI VA EL ID ASOCIADO RECIBIDO EN LA NOTIFICACIÓN
                            'idAsociado'=>$request->idAsociado,
                            //AQUI VA LA FECHA ACTUAL
                            'fechaRegistro'=>gmdate('Y-m-d\TH:i:s\Z'),
                            //AQUI VA EL TIPO DE MOVIMIENTO SIEMPRE 3 PARA INGRESO PARCIAL
                            'tipoMovimiento' => '3',
                            //1= FERROS 2= AEREOS 3=MUM
                            'detalleMovimiento'=>'2',
                            //1= IMPORTACIÓN 2= EXPORTACIÓN
                            'tipoOperacion'=>$request->tipoOperacion,
                            //AQUI VA EL CAMIR
                            'cveRecintoFiscalizado'=>$this->camir,
                            //AQUÍ VA H = HOUSE EN ESTE CASO
                            'tipoIngreso'=>'H'
                        ]
                    ],
                    ['guiasHouse'=>
                        [
                            //AQUÍ VA LA GUÍA HOUSE QUE SE VA A INGRESAR
                            'guiaHouse'=>$request->guiaHouse,
                            //ESTADIA EN EL RECINTO (1,3,5....DIAS)
                            'tipoMercancia'=>'1',
                            //FECHA EN LA QUE SE INCIO LA DESCARGA DE LA MERCANCIA EN EL RECINTO
                            'fechaInicioDescarga'=>$request->fechaInicioDescarga,
                            //FECHA EN LA QUE SE TERMINO LA DESCARGA DE LA MERCANCIA EN EL RECINTO
                            'fechaFinDescarga'=>$request->fechaFinDescarga,
                            //NUMERO DE LA PARCIALIDAD DEBE SER UN NUMERO CONSECUTIVO Y RESPETAR EL ORDEN SEGUN LAS PARCIALIDADES A INGRESAR
                            'numeroParcialidad'=>$request->numeroParcialidad,
                            //PESO DE LA MERCANCIA EN KG QUE SE VA A INGRESAR
                            'peso' => $request->peso,
                            //CANTIDAD DE PIEZAS
                            'cantidad'=>$request->cantidad,
                            //UNIDAD DE MEDIDA DE CANTIDAD
                            'umc'=>'PCS',
                            //1:OPTIMAS CONDICIONES, 2:CARGA MOJADA, 3:CARGA DAÑADA
                            'condicionCarga'=>$request->condicionCarga,
                            //OBSERVACIONES SOBRE LA MERCANCIA INGRESADA
                            'observaciones'=>$request->observaciones
                        ]
                    ]
                ];

                //Retorna el arrayObject directo del WS de VUCEM
                $call = $this->cliente->call('ingresoParcial',$data);
                $response = json_encode($call,200,[], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_INVALID_UTF8_IGNORE);

                //Guardando request en base de datos
                $LogData = new LogDataRequest;
                $LogData->consecutivo = $request->consecutivo;
                $LogData->idAsociado = $request->idAsociado;
                $LogData->tipo_request = 'ingresoParcialHouse';
                $LogData->data_request = json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_INVALID_UTF8_IGNORE);
                $LogData->data_response_json = $response;
                $LogData->data_response_xml = ArrayToXml::convert($call);
                $LogData->save();

                return response($response);
    }
    /*end IngresoParcial por Guía House*/

}
