<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

/*
|--------------------------------------------------------------------------
| Notificación de Ingreso de Mercancía
|--------------------------------------------------------------------------
*/
    Route::any('/', 'ServidorController@index');
    Route::get('/wsdl', 'ServidorController@wsdl')->name('wsdl');
/*
|--------------------------------------------------------------------------
| end Notificación de Ingreso de Mercancía
|--------------------------------------------------------------------------
*/

/*
|--------------------------------------------------------------------------
| Consulta alterna a Notificación de Ingreso de Mercancía
|--------------------------------------------------------------------------
*/
    Route::any('/ConsultaManifiestos', 'ConsultaManifiestosController@ConsultaManifiestos')
        ->name('cliente.consultamanifiestos');

    Route::any('/ConsultaDetalleGuia', 'ConsultaDetalleGuiaController@ConsultaDetalleGuia')
        ->name('cliente.consultadetalleguia');
/*
|--------------------------------------------------------------------------
| end Webservices de consulta alternos a Notificación de Ingreso de Mercancía
|--------------------------------------------------------------------------
*/

/*
|--------------------------------------------------------------------------
| Ingresos
|--------------------------------------------------------------------------
*/
    /*
    |--------------------------------------------------------------------------
    | Ingreso Simple
    |--------------------------------------------------------------------------
    */
    Route::any('/IngresoSimple/Master','IngresoSimpleController@IngresoSimpleMaster')
        ->name('cliente.ingresosimple.master');

    Route::any('/IngresoSimple/House','IngresoSimpleController@IngresoSimpleHouse')
        ->name('cliente.ingresosimple.house');
    /*
    |--------------------------------------------------------------------------
    |end IngresoSimple
    |--------------------------------------------------------------------------
    */

    /*
    |--------------------------------------------------------------------------
    | IngresoNoManifestado
    |--------------------------------------------------------------------------
    */
    Route::get('/IngresoNoManifestado','IngresoNoManifestadoController@IngresoNoManifestado')
        ->name('cliente.ingresonomanifestado');
    /*
    |--------------------------------------------------------------------------
    | end IngresoNoManifestado
    |--------------------------------------------------------------------------
    */

    /*
    |--------------------------------------------------------------------------
    | IngresoParcial
    |--------------------------------------------------------------------------
    */
    Route::get('/IngresoParcial/Master/','IngresoParcialController@IngresoParcialMaster')
        ->name('cliente.ingresoparcial.master');

    Route::get('/IngresoParcial/House','IngresoParcialController@IngresoParcialHouse')
        ->name('cliente.ingresoparcial.house');
    /*
    |--------------------------------------------------------------------------
    | end IngresoParcial
    |--------------------------------------------------------------------------
    */
/*
|--------------------------------------------------------------------------
| end Ingresos
|--------------------------------------------------------------------------
*/

/*
|--------------------------------------------------------------------------
| Salidas
|--------------------------------------------------------------------------
*/
    /*
    |--------------------------------------------------------------------------
    | Salida Master
    |--------------------------------------------------------------------------
    */
    Route::get('/Salida/Solicitud/Master','SalidasController@SolicitudSalidaMaster')
        ->name('cliente.salida.solicitud.master');

    Route::get('/Salida/Confirmacion/MasterDirecta','SalidasController@ConfirmacioSalidaMaster')
        ->name('cliente.salida.confirmacion.master');
    /*
    |--------------------------------------------------------------------------
    | end Salida Master
    |--------------------------------------------------------------------------
    */

    /*
    |--------------------------------------------------------------------------
    | Salida House
    |--------------------------------------------------------------------------
    */
    Route::get('/Salida/Solicitud/House','SalidasController@SolicitudSalidaHouse')
        ->name('cliente.salida.solicitud.house.directa');

    Route::get('/Salida/Confirmacion/House','SalidasController@ConfirmacionSalidaHouse')
        ->name('cliente.salida.confirmacion.house.directa');
    /*
    |--------------------------------------------------------------------------
    | end Salida House directa
    |--------------------------------------------------------------------------
    */
/*
|--------------------------------------------------------------------------
| end Salidas
|--------------------------------------------------------------------------
*/

/*
|--------------------------------------------------------------------------
| Cancelaciones
|--------------------------------------------------------------------------
*/

/*
|--------------------------------------------------------------------------
| end Cancelaciones
|--------------------------------------------------------------------------
*/

/*======================================================================================*/
//Inicia sección para consulta de información API Rest
/*======================================================================================*/

Route::get('/api/guiasmaster/', 'ApiController@verGuiasMaster')
    ->name('guiasmaster');
