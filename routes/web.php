<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::any('/', 'ServidorController@index');

Route::get('/wsdl', 'ServidorController@wsdl')
    ->name('wsdl');

Route::post('/ConsultaManifiestos', 'ConsultaManifiestosController@ConsultaManifiestos')
    ->name('cliente.consultamanifiestos');

Route::post('/ConsultaDetalleGuia', 'ConsultaDetalleGuiaController@ConsultaDetalleGuia')
    ->name('cliente.consultadetalleguia');

/*Ingreso Simple*/
Route::get('/IngresoSimpleMaster','IngresoSimpleController@IngresoSimpleMaster')
    ->name('cliente.ingresosimplemaster');

Route::get('/IngresoSimpleHouse','IngresoSimpleController@IngresoSimpleHouse')
    ->name('cliente.ingresosimplehouse');
/*end IngresoSimple */

/*IngresoNoManifestado*/
Route::get('/IngresoNoManifestado','IngresoNoManifestadoController@IngresoNoManifestado')
    ->name('cliente.ingresonomanifestado');
/*end IngresoNoManifestado*/

/*IngresoParcial*/
Route::get('/IngresoParcialMaster/{guiaMaster}','IngresoParcialController@IngresoParcialMaster')
    ->name('cliente.ingresoparcialmaster');

Route::get('/IngresoParcialHouse','IngresoParcialController@IngresoParcialHouse')
    ->name('cliente.ingresoparcialhouse');
/*end IngresoParcial*/
