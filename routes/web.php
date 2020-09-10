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
    Route::match(['get', 'post'], '/', 'ServidorController@index');
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
    Route::match(['get', 'post'],'/ConsultaManifiestos', 'ConsultaManifiestosController@ConsultaManifiestos')
        ->name('cliente.consultamanifiestos');

    Route::match(['get', 'post'],'/ConsultaDetalleGuia', 'ConsultaDetalleGuiaController@ConsultaDetalleGuia')
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
    Route::match(['get', 'post'],'/IngresoSimple/Master','IngresoSimpleController@IngresoSimpleMaster')
        ->name('cliente.ingresosimple.master');

    Route::match(['get', 'post'],'/IngresoSimple/House','IngresoSimpleController@IngresoSimpleHouse')
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
    Route::match(['get', 'post'],'/IngresoParcial/Master/','IngresoParcialController@IngresoParcialMaster')
        ->name('cliente.ingresoparcial.master');

    Route::match(['get', 'post'],'/IngresoParcial/House','IngresoParcialController@IngresoParcialHouse')
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
    Route::match(['get', 'post'],'/IngresoNoManifestado','IngresoNoManifestadoController@IngresoNoManifestado')
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
    Route::match(['get', 'post'],'/Salida/Solicitud/Master','SalidasController@SolicitudSalidaMaster')
        ->name('cliente.salida.solicitud.master');

    Route::match(['get', 'post'],'/Salida/Confirmacion/MasterDirecta','SalidasController@ConfirmacioSalidaMaster')
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
    Route::match(['get', 'post'],'/Salida/Solicitud/House','SalidasController@SolicitudSalidaHouse')
        ->name('cliente.salida.solicitud.house.directa');

    Route::match(['get', 'post'],'/Salida/Confirmacion/House','SalidasController@ConfirmacionSalidaHouse')
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
    Route::match(['get', 'post'],'/Salida/Cancelacion','CancelacionesController@Cancelaciones')
        ->name('cliente.salida.cancelacion');
/*
|--------------------------------------------------------------------------
| end Cancelaciones
|--------------------------------------------------------------------------
*/

/*======================================================================================*/
//Inicia sección para consulta de información API Rest
/*======================================================================================*/

Route::match(['get', 'post'],'/api/notificaciones/', 'ApiController@getAllNotificaciones')
    ->name('getAllNotificaciones');
