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
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use App\Helpers\nusoap_client;
use Config;

class SalidasController extends Controller
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

    /*Salida por Guía Master*/
    public function SolicitudSalidaMaster(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'consecutivo' => 'required',
            'idAsociado' => 'required',
            'tipoOperacion' => 'required',
            'pedimento' => 'required',
            'patente' => 'required',
            'cvePedimento' => 'required',
            'numMaster' => 'required',
            'numPiezas' => 'required',
            'peso' => 'required'
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
                        //AQUI VA LA FECHA ACTUAL
                        'fechaRegistro'=>gmdate('Y-m-d\TH:i:s\Z'),
                        //AQUI VA EL TIPO DE MOVIMIENTO SIEMPRE 11 PARA SALIDAS
                        'tipoMovimiento' => '11',
                        //1= FERROS 2= AEREOS 3=MUM
                        'detalleMovimiento'=>'2',
                        //1= IMPORTACIÓN 2= EXPORTACIÓN
                        'tipoOperacion'=>$request->tipoOperacion,
                        //AQUI VA EL CAMIR
                        'cveRecintoFiscalizado'=>$this->camir,
                    ]
                ],
                ['tipoSalida' => 'M'],
                ['master' =>
                    [
                        //AQUI VA EL NÚMERO DE PEDIMENTO
                        'pedimento'=>$request->pedimento,
                        //AQUI VA EL NÚMERO DE ADUANA 070 = CDMX
                        'aduana'=>'070',
                        //AQUI VA EL NÚMERO DE PATENTE
                        'patente'=>$request->patente,
                        //AQUI VA LA CLAVE DEL PEDIMENTO
                        'cvePedimento'=>$request->cvePedimento,
                        //AQUI VA EL NÚMERO DE MASTER CON PREFIJO XYZ-NNNNNNN
                        'numMaster'=>$request->numMaster,
                        //AQUI VA LA INFORMACIÓN DE LA MERCANCÍA A SALIR
                        'mercancia'=>[
                            //AQUI VA LA CANTIDAD DE PIEZAS
                            'numPiezas' =>$request->numPiezas,
                            //AQUI VA LA UNIDAD DE MEDIDA EN CANTIDAD DE PIEZAS
                            'umc' => 'PCS',
                            //AQUI VA LA UNIDAD DE MEDIDA EN PESO
                            'ump' => 'K',
                            //AQUI VA EL PESO DE LA CARGA A SALIR
                            'peso' =>$request->peso
                        ]
                    ]
                ]
            ];

        $call = $this->cliente->call('salidaPedimento',$data);
        return response()->json($call, JSON_UNESCAPED_UNICODE );
    }

    /*Confirmación de salida por Guía House*/
    public function ConfirmacionSalidaMaster(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'consecutivo' => 'required',
            'idAsociado' => 'required',
            'tipoOperacion' => 'required',
            'pedimento' => 'required',
            'patente' => 'required',
            'cvePedimento' => 'required',
            'numMaster' => 'required',
            'numPiezas' => 'required',
            'peso' => 'required'
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
                        //AQUI VA LA FECHA ACTUAL
                        'fechaRegistro'=>gmdate('Y-m-d\TH:i:s\Z'),
                        //AQUI VA EL TIPO DE MOVIMIENTO SIEMPRE 11 PARA SALIDAS
                        'tipoMovimiento' => '11',
                        //1= FERROS 2= AEREOS 3=MUM
                        'detalleMovimiento'=>'6',
                        //1= IMPORTACIÓN 2= EXPORTACIÓN
                        'tipoOperacion'=>$request->tipoOperacion,
                        //AQUI VA EL CAMIR
                        'cveRecintoFiscalizado'=>$this->camir,
                    ]
                ],
                ['tipoSalida' => 'M'],
                ['master' =>
                    [
                        //AQUI VA EL NÚMERO DE PEDIMENTO
                        'pedimento'=>$request->pedimento,
                        //AQUI VA EL NÚMERO DE ADUANA 070 = CDMX
                        'aduana'=>'070',
                        //AQUI VA EL NÚMERO DE PATENTE
                        'patente'=>$request->patente,
                        //AQUI VA LA CLAVE DEL PEDIMENTO
                        'cvePedimento'=>$request->cvePedimento,
                        //AQUI VA EL NÚMERO DE MASTER CON PREFIJO XYZ-NNNNNNN
                        'numMaster'=>$request->numMaster,
                        //AQUI VA LA INFORMACIÓN DE LA MERCANCÍA A SALIR
                        'mercancia'=>[
                            //AQUI VA LA CANTIDAD DE PIEZAS
                            'numPiezas' =>$request->numPiezas,
                            //AQUI VA LA UNIDAD DE MEDIDA EN CANTIDAD DE PIEZAS
                            'umc' => 'PCS',
                            //AQUI VA LA UNIDAD DE MEDIDA EN PESO
                            'ump' => 'K',
                            //AQUI VA EL PESO DE LA CARGA A SALIR
                            'peso' =>$request->peso
                        ]
                    ]
                ]
            ];

        $call = $this->cliente->call('confirmacionDeSalida',$data);
        return response()->json($call, JSON_UNESCAPED_UNICODE );
    }

    /*Solicitud de salida por Guía House*/
    public function SolicitudSalidaHouse(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'consecutivo' => 'required',
            'idAsociado' => 'required',
            'tipoOperacion' => 'required',
            'pedimento' => 'required',
            'patente' => 'required',
            'cvePedimento' => 'required',
            'numMaster' => 'required',
            'numPiezas' => 'required',
            'numHouse' => 'required',
            'peso' => 'required'
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
                        //AQUI VA LA FECHA ACTUAL
                        'fechaRegistro'=>gmdate('Y-m-d\TH:i:s\Z'),
                        //AQUI VA EL TIPO DE MOVIMIENTO SIEMPRE 11 PARA SALIDAS
                        'tipoMovimiento' => '11',
                        //1= FERROS 2= AEREOS 3=MUM 6=SALIDAS
                        'detalleMovimiento'=>'6',
                        //1= IMPORTACIÓN 2= EXPORTACIÓN
                        'tipoOperacion'=>$request->tipoOperacion,
                        //AQUI VA EL CAMIR
                        'cveRecintoFiscalizado'=>$this->camir,
                    ]
                ],
                ['tipoSalida' => 'H'],
                ['master' =>
                    [
                        //AQUI VA EL NÚMERO DE PEDIMENTO
                        'pedimento'=>$request->pedimento,
                        //AQUI VA EL NÚMERO DE ADUANA 070 = CDMX
                        'aduana'=>'070',
                        //AQUI VA EL NÚMERO DE PATENTE
                        'patente'=>$request->patente,
                        //AQUI VA LA CLAVE DEL PEDIMENTO
                        'cvePedimento'=>$request->cvePedimento,
                        //AQUI VA EL NÚMERO DE MASTER CON PREFIJO XYZ-NNNNNNN
                        'numMaster'=>$request->numMaster,
                        //AQUI VA LA INFORMACIÓN DE LA MERCANCÍA A SALIR
                        'mercancia'=>[
                            //AQUI VA LA CANTIDAD DE PIEZAS
                            'numPiezas'=>$request->numPiezas,
                            //AQUI VA LA UNIDAD DE MEDIDA EN CANTIDAD DE PIEZAS
                            'umc' => 'PCS',
                            //AQUI VA LA UNIDAD DE MEDIDA EN PESO
                            'ump' => 'K',
                            //AQUI VA EL PESO DE LA CARGA A SALIR
                            'peso' =>$request->peso
                        ],
                        'house'=>[
                            'numHouse'=>$request->numHouse,
                            'mercancia'=>[
                                //AQUI VA LA CANTIDAD DE PIEZAS
                                'numPiezas' => $request->numPiezas,
                                //AQUI VA LA UNIDAD DE MEDIDA EN CANTIDAD DE PIEZAS
                                'umc' => 'PCS',
                                //AQUI VA LA UNIDAD DE MEDIDA EN PESO
                                'ump' => 'K',
                                //AQUI VA EL PESO DE LA CARGA A SALIR
                                'peso' => $request->peso
                            ],
                        ]
                    ]
                ]
            ];

        $call = $this->cliente->call('salidaPedimento',$data);
        return response()->json($call, JSON_UNESCAPED_UNICODE );
    }

    /*Confirmación de salida por Guía House*/
    public function ConfirmacionSalidaHouse(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'consecutivo' => 'required',
            'idAsociado' => 'required',
            'tipoOperacion' => 'required',
            'pedimento' => 'required',
            'patente' => 'required',
            'cvePedimento' => 'required',
            'numMaster' => 'required',
            'numPiezas' => 'required',
            'numHouse' => 'required',
            'peso' => 'required'
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
                        //AQUI VA LA FECHA ACTUAL
                        'fechaRegistro'=>gmdate('Y-m-d\TH:i:s\Z'),
                        //AQUI VA EL TIPO DE MOVIMIENTO SIEMPRE 11 PARA SALIDAS
                        'tipoMovimiento' => '11',
                        //1= FERROS 2= AEREOS 3=MUM
                        'detalleMovimiento'=>'6',
                        //1= IMPORTACIÓN 2= EXPORTACIÓN
                        'tipoOperacion'=>'1',
                        //AQUI VA EL CAMIR
                        'cveRecintoFiscalizado'=>$this->camir,
                    ]
                ],
                ['tipoSalida' => 'H'],
                ['master' =>
                    [
                        //AQUI VA EL NÚMERO DE PEDIMENTO
                        'pedimento'=>$request->pedimento,
                        //AQUI VA EL NÚMERO DE ADUANA 070 = CDMX
                        'aduana'=>'070',
                        //AQUI VA EL NÚMERO DE PATENTE
                        'patente'=>$request->patente,
                        //AQUI VA LA CLAVE DEL PEDIMENTO
                        'cvePedimento'=>$request->cvePedimento,
                        //AQUI VA EL NÚMERO DE MASTER CON PREFIJO XYZ-NNNNNNN
                        'numMaster'=>$request->numMaster,
                        //AQUI VA LA INFORMACIÓN DE LA MERCANCÍA A SALIR
                        'mercancia'=>[
                            //AQUI VA LA CANTIDAD DE PIEZAS
                            'numPiezas'=>$request->numPiezas,
                            //AQUI VA LA UNIDAD DE MEDIDA EN CANTIDAD DE PIEZAS
                            'umc' => 'PCS',
                            //AQUI VA LA UNIDAD DE MEDIDA EN PESO
                            'ump' => 'K',
                            //AQUI VA EL PESO DE LA CARGA A SALIR
                            'peso' =>$request->peso
                        ],
                        'house'=>[
                            'numHouse'=>$request->numHouse,
                            'mercancia'=>[
                                //AQUI VA LA CANTIDAD DE PIEZAS
                                'numPiezas' => $request->numPiezas,
                                //AQUI VA LA UNIDAD DE MEDIDA EN CANTIDAD DE PIEZAS
                                'umc' => 'PCS',
                                //AQUI VA LA UNIDAD DE MEDIDA EN PESO
                                'ump' => 'K',
                                //AQUI VA EL PESO DE LA CARGA A SALIR
                                'peso' => $request->peso
                            ],
                        ]
                    ]
                ]
            ];

        $call = $this->cliente->call('confirmacionDeSalida',$data);
        return response()->json($call, JSON_UNESCAPED_UNICODE );
    }

}
