<?php

/*
*  Webservice VUCEM/SIRA basado en Manual de Operación SIRA v3.7
*  Desarrollado por Cristian Omar Vega Mendoza.
*/

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;
//use App\Helpers\nusoap_client;
use Config;
use nusoap_client;

class ConsultaManifiestosController extends Controller
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
        $this->endpoint = Config::get('app.vucemsira.endpoint_manifiesto');

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
        $this->cliente->soap_defencoding = 'UTF-8';
        $this->cliente->decode_utf8 = FALSE;
        $this->cliente->setEndpoint($this->endpoint);
        $this->cliente->setHeaders($header);
        //$this->cliente->setCredentials($this->username, $this->password);
    }


    /**
     * [ConsultaManifiestos Obtiene las guías masters que corresponden a un manifiesto determinado]
     * @param Request $request [manifiesto]
     * Si correcto
     * @param Return {"return":{"numeroManifest":"String","masters":[Array Unidimensional]}}
     * Si hay error
     * @param Return {"return":{"mensajes":"String"}}
     */
    public function ConsultaManifiestos(Request $request)
    {
        $data = ['arg0'=>['camir'=>$this->camir,'trafico'=>$this->trafico,'manifiesto'=>$request->manifiesto]];
        $call = $this->cliente->call('consultaManifiesto', $data);
        return response()->json($call,200,[],JSON_PRETTY_PRINT|JSON_UNESCAPED_UNICODE );
    }
}
