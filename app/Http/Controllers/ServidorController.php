<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Helpers\Server;

class ServidorController extends Controller
{
    public function index(Server $sira)
    {
       $soapServer = new \SoapServer(route('wsdl'));
       $soapServer->setObject($sira);

       $response = new Response();
       $response->headers->set('Content-Type', 'text/xml; charset=ISO-8859-1');

       ob_start();
       $soapServer->handle();
       $response->setContent(ob_get_clean());

       return $response;
    }

    public function wsdl()
    {
        $nameSpace = 'http://service.common.www.ventanillaunica.gob.mx/';
        $soapAction = url('/');
        return response()->view('wsdl', compact('nameSpace','soapAction') )->header('Content-Type', 'text/xml');
    }
}
