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
    | IngresoParcial
    |--------------------------------------------------------------------------
    */
    Route::any('/IngresoParcial/Master/','IngresoParcialController@IngresoParcialMaster')
        ->name('cliente.ingresoparcial.master');

    Route::any('/IngresoParcial/House','IngresoParcialController@IngresoParcialHouse')
        ->name('cliente.ingresoparcial.house');
    /*
    |--------------------------------------------------------------------------
    | end IngresoParcial
    |--------------------------------------------------------------------------
    */


    /*
    |--------------------------------------------------------------------------
    | IngresoNoManifestado
    |--------------------------------------------------------------------------
    */
    Route::any('/IngresoNoManifestado','IngresoNoManifestadoController@IngresoNoManifestado')
        ->name('cliente.ingresonomanifestado');
    /*
    |--------------------------------------------------------------------------
    | end IngresoNoManifestado
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
    Route::any('/Salida/Solicitud/Master','SalidasController@SolicitudSalidaMaster')
        ->name('cliente.salida.solicitud.master');

    Route::any('/Salida/Confirmacion/MasterDirecta','SalidasController@ConfirmacioSalidaMaster')
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
    Route::any('/Salida/Solicitud/House','SalidasController@SolicitudSalidaHouse')
        ->name('cliente.salida.solicitud.house.directa');

    Route::any('/Salida/Confirmacion/House','SalidasController@ConfirmacionSalidaHouse')
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
    Route::any('/Salida/Cancelacion','CancelacionesController@Cancelaciones')
        ->name('cliente.salida.cancelacion');
/*
|--------------------------------------------------------------------------
| end Cancelaciones
|--------------------------------------------------------------------------
*/

/*======================================================================================*/
//Inicia sección para consulta de información API Rest
/*======================================================================================*/

Route::any('/api/guiasmaster/', 'ApiController@verGuiasMaster')
    ->name('guiasmaster');
