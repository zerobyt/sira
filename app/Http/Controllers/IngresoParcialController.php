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

class IngresoParcialController extends Controller
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

    /*IngresoParcial por Guía Master*/
    public function IngresoParcialMaster(Request $request)
    {
        //Busca la guía ingresada en la base de datos
        $guia = Guia::Where('numeroGuiaBl',$request->guiaMaster)->first();
        if(!$guia){
            return json_encode(['response'=>'error','message'=>'No se ha localizado el registro, verifique el la notificacion de ingreso'],JSON_UNESCAPED_UNICODE);
        }

        // $client = new \GuzzleHttp\Client(['verify' => false]);
        // $response = $client->request('GET', route('cliente.consultadetalleguia', ['manifiesto'=>'262000020200521ZAZ', 'guiaMaster'=>'204-20200521']) );
        // $response = $response->getBody()->getContents();
        // print_r($response);

        $data = ['arg0'=>
                    ['informacionGeneral' =>
                        [
                            //AQUI VA EL ID ASOCIADO RECIBIDO EN LA NOTIFICACIÓN
                            'consecutivo'=>$request->consecutivo,
                            'idAsociado'=>$request->idAsociado,
                            //AQUI VA LA FECHA ACTUAL
                            'fechaRegistro'=>gmdate('Y-m-d\TH:i:s\Z'),
                            //QUI VA SIEMPRE 3, CORRESPONDE AL INGRESO PARCIAL
                            'tipoMovimiento'=>'3',
                            //1= FERROS 2= AEREOS 3=MUM
                            'detalleMovimiento'=>'2',
                            //1= IMPORTACIÓN 2= EXPORTACIÓN
                            'tipoOperacion'=>'1',
                            //AQUI VA EL CAMIR
                            'cveRecintoFiscalizado'=>$this->camir,
                            //AQUÍ VA M = MASTER EN ESTE CASO
                            'tipoIngreso'=>'M'
                        ]
                    ],
                    ['informacionIngresoParcial'=>
                        [
                            //ESTADIA EN EL RECINTO (1,3,5....DIAS)
                            'tipoMercancia'=>'1',
                            //FECHA EN LA QUE SE INCIO LA DESCARGA DE LA MERCANCIA EN EL RECINTO
                            'fechaInicioDescarga'=>gmdate('Y-m-d\TH:i:s\Z', time() - 35),
                            //FECHA EN LA QUE SE TERMINO LA DESCARGA DE LA MERCANCIA EN EL RECINTO
                            'fechaFinDescarga'=>gmdate('Y-m-d\TH:i:s\Z', time() - 15),
                            //PESO DE LA MERCANCIA EN KG QUE SE VA A INGRESAR
                            'peso' => $request->peso,
                            //NUMERO DE LA PARCIALIDAD DEBE SER UN NUMERO CONSECUTIVO Y RESPETAR EL ORDEN SEGUN LAS PARCIALIDADES A INGRESAR
                            'numeroParcialidad'=>'',
                            //CANTIDAD DE PIEZAS
                            'cantidad'=>'',
                            //UNIDAD DE MEDIDA DE CANTIDAD
                            'umc'=>'PCS',
                            //1:OPTIMAS CONDICIONES, 2:CARGA MOJADA, 3:CARGA DAÑADA
                            'condicionCarga'=>'1',
                            //OBSERVACIONES SOBRE LA MERCANCIA INGRESADA
                            'observaciones'=>'',
                            //SI HAY VINS EN LA PARCIALIDAD SE DEFINE EL SEGMENTO SINO SOLO SE DECLARA <vin>NUMERO_VIN</vin>
                            'vins'=>'',
                        ]
                    ],
                    ['guiasHouse'=>
                        [
                            'guiaHouse'=>'',
                            'tipoMercancia'=>'',
                            'fechaInicioDescarga'=>'',
                            'fechaFinDescarga'=>'',
                            'numeroParcialidad'=>'',
                            'peso'=>'',
                            'cantidad'=>'',
                            'umc'=>'',
                            'condicionCarga'=>'',
                            'observaciones'=>''
                        ]
                    ]
                ];
    }
    /*end IngresoParcial por Guía Master*/

    /*Ingreso Parcial por Guía House*/
    public function IngresoParcialHouse(Request $request)
    {
        $data = ['arg0'=>
                    ['informacionGeneral' =>
                        [
                            //AQUI VA EL ID ASOCIADO RECIBIDO EN LA NOTIFICACIÓN
                            'consecutivo'=>'20000009K',
                            'idAsociado'=>'20000009K',
                            //AQUI VA LA FECHA ACTUAL
                            'fechaRegistro'=>gmdate('Y-m-d\TH:i:s\Z'),
                            //QUI VA SIEMPRE 3, CORRESPONDE AL INGRESO PARCIAL
                            'tipoMovimiento'=>'3',
                            //1= FERROS 2= AEREOS 3=MUM
                            'detalleMovimiento'=>'2',
                            //1= IMPORTACIÓN 2= EXPORTACIÓN
                            'tipoOperacion'=>'1',
                            //AQUI VA EL CAMIR
                            'cveRecintoFiscalizado'=>$this->camir,
                            //AQUÍ VA M = MASTER EN ESTE CASO
                            'tipoIngreso'=>'H'
                        ]
                    ,'informacionIngresoParcial'=>
                        [
                            'tipoMercancia'=>'',
                            'fechaInicioDescarga'=>'',
                            'fechaFinDescarga'=>'',
                            'peso'=>'',
                            'numeroParcialidad'=>'',
                            'cantidad'=>'',
                            'umc'=>'',
                            'condicionCarga'=>'',
                            'observaciones'=>'',
                            'vins'=>['vin'=>''],
                        ]
                    ,'guiasHouse'=>
                        [
                            //SE DECLARA Y SE DEFINE LA GUIA HOUSE A INGRESAR
                            'guiaHouse'=>'ZB22220200521',
                            //ESTADIA EN EL RECINTO (1,3,5....DIAS)
                            'tipoMercancia'=>'1',
                            //FECHA EN LA QUE SE INCIO LA DESCARGA DE LA MERCANCIA EN EL RECINTO
                            'fechaInicioDescarga'=>gmdate('Y-m-d\TH:i:s\Z', time() - (35*60)),
                            //FECHA EN LA QUE SE TERMINO LA DESCARGA DE LA MERCANCIA EN EL RECINTO
                            'fechaFinDescarga'=>gmdate('Y-m-d\TH:i:s\Z', time() - (15*60)),
                            //NUMERO DE LA PARCIALIDAD DEBE SER UN NUMERO CONSECUTIVO Y RESPETAR EL ORDEN SEGUN LAS PARCIALIDADES A INGRESAR
                            'numeroParcialidad'=>'1',
                            'peso'=>'310',
                            //CANTIDAD DE PIEZAS
                            'cantidad'=>'70',
                            //UNIDAD DE MEDIDA DE CANTIDAD
                            'umc'=>'PCS',
                            //1:OPTIMAS CONDICIONES, 2:CARGA MOJADA, 3:CARGA DAÑADA
                            'condicionCarga'=>'1',
                            //OBSERVACIONES SOBRE LA MERCANCIA INGRESADA
                            'observaciones'=>'PRIMERA PARCIALIDAD HOUSE ZB22220200521'
                        ]
                    ]
                ];
            $call = $this->cliente->call('ingresoParcial',$data);
            $error = $this->cliente->getError();

            if($error){
                print_r($error);
            }else{
               echo "IngresoParcialHouse<br>";
               echo "Servicio Consultado: ".$this->endpoint."?wsdl <br>";
               echo "Datos enviados: <br>";
               echo json_encode($data);
               echo "<br><br><br>";
               echo "Respuesta:<br>";
               echo json_encode($call);
            }
    }
    /*end IngresoParcial por Guía House*/

}
