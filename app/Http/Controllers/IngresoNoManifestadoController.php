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
use App\Helpers\nusoap_client;
use Config;
use Spatie\ArrayToXml\ArrayToXml;

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
        $this->cliente->setCredentials($this->username, $this->password);
    }

    /*IngresoNoManifestado*/
    public function IngresoNoManifestado(Request $request)
    {
        $informacionGeneral =
            [
                //AQUI VA LA FECHA ACTUAL FORMATO YYYY-MM-DDTHH:MM:SSZ
                'fechaRegistro'=>gmdate('Y-m-d\TH:i:s\Z'),
                //QUI VA SIEMPRE 4, CORRESPONDE AL INGRESO NO MANIFESTADO
                'tipoMovimiento'=>'4',
                //1= FERROS 2= AEREOS 3=MUM
                'detalleMovimiento'=>'2',
                //AQUI VA EL CAMIR DEL RECINTO
                'cveRecintoFiscalizado'=>$this->camir,
            ];

        $transporte = ['tipoTransporte' => 'A'];

        $make_informacionGeneral['informacionGeneral'] = array_merge($request->informacionGeneral,$informacionGeneral);
        $make_informaciondeIngreso['informacionIngreso'] = $request->informacionIngreso;
        $make_transporte['transporte'] = array_merge($request->transporte,$transporte);
        $make_guiaMaster['guiaMaster'] = $request->guiaMaster;


        $data['arg0'] =
            array_merge(
                $make_informacionGeneral,
                $make_informaciondeIngreso,
                $make_transporte,
                $make_guiaMaster
            );

            //echo ArrayToXml::convert($data);
        // $data =
        //     ["arg0"=>
        //         ["informacionGeneral" =>
        //             [
        //               "consecutivo"=>"20000006Q",
        //               "idAsociado"=>"20000006Q",
        //               "fechaRegistro"=>"2020-05-11T14:11:32-05:00",
        //               "tipoMovimiento"=>"4",
        //               "detalleMovimiento"=>"2",
        //               "tipoOperacion"=>"1",
        //               "cveRecintoFiscalizado"=>"4718"
        //           ]
        //         ,"informacionIngreso" =>
        //             [
        //               "tipoMercancia"=>"1",
        //               "fechaInicioDescarga"=>"2020-01-21T18:21:34.290Z",
        //               "fechaFinDescarga"=>"2020-01-21T18:51:34.290Z",
        //               "peso"=>"16.1",
        //               "condicionCarga"=>"1",
        //               "observaciones"=>"observaciones"
        //           ]
        //         ,"transporte" =>
        //             [
        //               "numeroVueloBuqueViajeImo"=>"5544",
        //               "tipoTransporte"=>"A",
        //               "fechaHoraDeArribo"=>"2020-04-14T11:55:00-05:00",
        //               "origenVueloBuque"=>"CTG",
        //               "numeroManifiesto"=>"1115544202004144701ROSAB",
        //               "caat"=>"2E9T",
        //               "peso"=>"16.1",
        //               "ump"=>"K",
        //               "piezas"=>"23.0"
        //           ]
        //         ,"guiaMaster" =>
        //             [
        //               "numeroGuiaBl"=>"222-20200424",
        //               "caat"=>"2E9T",
        //               "tipoOperacion"=>"1",
        //               "peso"=>"16.1",
        //               "ump"=>"K",
        //               "volumen"=>"23.0",
        //               "umv"=>"M3",
        //               "piezas"=>"3000.0",
        //               "idParcialidad"=>"T",
        //               "secuencia"=>"1",
        //               "observaciones"=>"9111500",
        //               "mercancia" => [
        //                      "secuencia"=>"1",
        //                      "pais"=>"CVG",
        //                      "descripcion"=>"Mensajeria y Paqueteria",
        //                      "peso"=>"14.1",
        //                      "ump"=>"K",
        //                      "volumen"=>"23.0",
        //                      "vin" => [
        //                          "vin" => "123456789",
        //                          "vin" => "987654321"
        //                      ]
        //                      ,"imo" => [
        //                         "imo"=>"193746285",
        //                         "imo"=>"582647391"
        //                      ]
        //                  ],
        //               "personas" => [
        //                  [
        //                     "tipoPersona"=>"TIN TIN",
        //                     "nombre"=>"NOMBRE PERSONA",
        //                     "calleDomicilio"=>"CALLE DOMICILIO",
        //                     "numeroInterior"=>'',
        //                     "numeroExterior"=>"34",
        //                     "cp"=>"03500",
        //                     "municipio"=>"VENUSTIANO CARRANZA",
        //                     "entidadFederativa"=>"MEXICO",
        //                     "pais"=>"MEX",
        //                     "rfcOTaxId"=>"ABC94269",
        //                     "correoElectronico"=>"correo@correo.com",
        //                     "ciudad"=>"CMDX",
        //                     "contacto"=>"NOMBRE DE CONTACTO",
        //                     "telefono"=>"555555555",
        //                     "correoContacto"=>"correo@correo.com"
        //                 ],
        //                 [
        //                     "tipoPersona"=>"SH",
        //                     "nombre"=>"NOMBRE PERSONA SH",
        //                     "calleDomicilio"=>"CALLE DOMICILIO",
        //                     "numeroInterior"=>'',
        //                     "numeroExterior"=>"34",
        //                     "cp"=>"03500",
        //                     "municipio"=>"VENUSTIANO CARRANZA",
        //                     "entidadFederativa"=>"MEXICO",
        //                     "pais"=>"MEX",
        //                     "rfcOTaxId"=>"ABC94269",
        //                     "correoElectronico"=>"correo@correo.com",
        //                     "ciudad"=>"CMDX",
        //                     "contacto"=>"NOMBRE DE CONTACTO",
        //                     "telefono"=>"555555555",
        //                     "correoContacto"=>"correo@correo.com"
        //                 ],
        //                 [
        //                     "tipoPersona"=>"N1",
        //                     "nombre"=>"NOMBRE PERSONA N1",
        //                     "calleDomicilio"=>"CALLE DOMICILIO",
        //                     "numeroInterior"=>'',
        //                     "numeroExterior"=>"34",
        //                     "cp"=>"03500",
        //                     "municipio"=>"VENUSTIANO CARRANZA",
        //                     "entidadFederativa"=>"MEXICO",
        //                     "pais"=>"MEX",
        //                     "rfcOTaxId"=>"ABC94269",
        //                     "correoElectronico"=>"correo@correo.com",
        //                     "ciudad"=>"CMDX",
        //                     "contacto"=>"NOMBRE DE CONTACTO",
        //                     "telefono"=>"555555555",
        //                     "correoContacto"=>"correo@correo.com"
        //                 ]
        //              ],"guiaHouse"=>[
        //                     [
        //                         "numeroGuiaBl"=>"HOUSE003ISELA4701G",
        //                         "caat"=>"2415",
        //                         "tipoOperacion"=>"1",
        //                         "valorDeclarado"=>"23.0",
        //                         "moneda"=>"USD",
        //                         "peso"=>"1.0",
        //                         "ump"=>"K",
        //                         "volumen"=>"23.0",
        //                         "umv"=>"M3",
        //                         "piezas"=>"1.0",
        //                         "secuencia"=>"1",
        //                         "observaciones"=>"9111496",
        //                         "mercancia" =>
        //                         [
        //                            "secuencia"=>"1",
        //                            "pais"=>"MEX",
        //                            "descripcion"=>"CAMERA CASE",
        //                            "peso"=>"1.0",
        //                            "ump"=>"K",
        //                            "volumen"=>"23.0",
        //                            "vin" => [
        //                               "vin"=>"123456789"
        //                           ]
        //                         ],"personas"=>[
        //                            [
        //                               "tipoPersona"=>"TIN TIN",
        //                               "nombre"=>"GUANGZHOU SAILU INFOTECH CO LTD",
        //                               "calleDomicilio"=>"NAN HANG HUO YUN DA LOU YUAN NEI CA",
        //                               "cp"=>"94345",
        //                               "municipio"=>"GUANGZHOU CN",
        //                               "entidadFederativa"=>"CHINA",
        //                               "pais"=>"CHN",
        //                               "rfcOTaxId"=>"46578498"
        //                            ],
        //                            [
        //                               "tipoPersona"=>"SH",
        //                               "nombre"=>"JOSE ANTONIO DE LA TORRE BRAVO",
        //                               "calleDomicilio"=>"AV LA CIMA 296 COTO J CASA 27 LA CI",
        //                               "cp"=>"03400",
        //                               "municipio"=>"GUADALAJARA",
        //                               "entidadFederativa"=>"MEXICO",
        //                               "pais"=>"MEX",
        //                               "rfcOTaxId"=>"46578100"
        //                           ],
        //                           [
        //                               "tipoPersona"=>"IF",
        //                               "nombre"=>"DHL EXPRESS",
        //                               "calleDomicilio"=>"236 WENDELL FORD BLVD",
        //                               "cp"=>"94345",
        //                               "municipio"=>"CINCINNATI",
        //                               "entidadFederativa"=>"ESTADOS UNIDOS",
        //                               "pais"=>"USA",
        //                               "rfcOTaxId"=>"123456"
        //                           ],
        //                           [
        //                               "tipoPersona"=>"N1",
        //                               "nombre"=>"DHL EXPRESS",
        //                               "calleDomicilio"=>"CALLE BENITO JUAREZ 33",
        //                               "cp"=>"04250",
        //                               "municipio"=>"CINCINNATI",
        //                               "entidadFederativa"=>"ESTADOS UNIDOS",
        //                               "pais"=>"USA",
        //                               "rfcOTaxId"=>'ABC94269'
        //                           ]
        //                         ]
        //                     ],
        //                     [
        //                         "numeroGuiaBl"=>"HOUSE004ISELA4701F",
        //                         "caat"=>"2415",
        //                         "tipoOperacion"=>"1",
        //                         "valorDeclarado"=>"23.0",
        //                         "moneda"=>"USD",
        //                         "peso"=>"1.0",
        //                         "ump"=>"K",
        //                         "volumen"=>"23.0",
        //                         "umv"=>"M3",
        //                         "piezas"=>"1.0",
        //                         "secuencia"=>"2",
        //                         "observaciones"=>"9111497",
        //                         "mercancia"=>[
        //                            "secuencia"=>"1",
        //                            "pais"=>"CHN",
        //                            "descripcion"=>"CAMERA CASE",
        //                            "peso"=>"1.0",
        //                            "ump"=>"K",
        //                            "volumen"=>"23.0",
        //                            "vin"=>[
        //                               "vin"=>"123456789"
        //                            ]
        //                         ],
        //                         "personas"=>[
        //                            [
        //                               "tipoPersona"=>"TIN TIN",
        //                               "nombre"=>"GUANGZHOU SAILU INFOTECH CO LTD",
        //                               "calleDomicilio"=>"NAN HANG HUO YUN DA LOU YUAN NEI CA",
        //                               "cp"=>"94345",
        //                               "municipio"=>"GUANGZHOU CN",
        //                               "entidadFederativa"=>"CHINA",
        //                               "pais"=>"CHN",
        //                               "rfcOTaxId"=>"46578498"
        //                           ],
        //                           [
        //                               "tipoPersona"=>"SH",
        //                               "nombre"=>"JOSE ANTONIO DE LA TORRE BRAVO",
        //                               "calleDomicilio"=>"AV LA CIMA 296 COTO J CASA 27 LA CI",
        //                               "cp"=>"03400",
        //                               "municipio"=>"GUADALAJARA",
        //                               "entidadFederativa"=>"MEXICO",
        //                               "pais"=>"MEX",
        //                               "rfcOTaxId"=>"46578100"
        //                           ],
        //                           [
        //                               "tipoPersona"=>"IF",
        //                               "nombre"=>"DHL EXPRESS",
        //                               "calleDomicilio"=>"236 WENDELL FORD BLVD",
        //                               "cp"=>"94345",
        //                               "municipio"=>"CINCINNATI",
        //                               "entidadFederativa"=>"ESTADOS UNIDOS",
        //                               "pais"=>"USA",
        //                               "rfcOTaxId"=>"123456"
        //                           ],
        //                           [
        //                               "tipoPersona"=>"N1",
        //                               "nombre"=>"DHL EXPRESS",
        //                               "calleDomicilio"=>"CALLE BENITO JUAREZ 33",
        //                               "cp"=>"04250",
        //                               "municipio"=>"CINCINNATI",
        //                               "entidadFederativa"=>"ESTADOS UNIDOS",
        //                               "pais"=>"USA",
        //                               "rfcOTaxId"=>'ABC94269'
        //                            ]
        //                         ]
        //                     ]
        //                   ]
        //               ]
        //           ]
        //       ];
              $call = $this->cliente->call('ingresoNoManifestado',$data);
              $response = json_encode($call, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_INVALID_UTF8_IGNORE);

              //Guardando request en base de datos
              $LogData = new LogDataRequest;
              $LogData->consecutivo = $request->informacionGeneral['consecutivo'];
              $LogData->idAsociado = $request->informacionGeneral['idAsociado'];
              $LogData->tipo_request = 'ingresoNoManifestado';
              $LogData->data_request = json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_INVALID_UTF8_IGNORE);
              $LogData->data_response_json = $response;
              $LogData->data_response_xml = ArrayToXml::convert($call);
              $LogData->save();

              return response($response);
    }
    /*end IngresoNoManifestado*/
}
