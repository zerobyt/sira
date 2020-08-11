<?php

namespace App\Helpers;

use App\Models\Guia;
use App\Models\InformacionGeneral;
use App\Models\Mercancia;
use App\Models\Personas;
use App\Models\Transporte;
use App\Models\Vin;
use App\Models\Imo;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;

class Server
{
    public function notificacionIngresoMercancia($request)
    {
        //Segmentación de Request--------------------------------------->>>>>>>
        $igReq = isset($request->informacionGeneral) ? $request->informacionGeneral : NULL;
        $trReq = isset($request->transporte) ? $request->transporte : NULL;
        $gmReq = isset($request->guiaMaster) ? $request->guiaMaster : NULL;
        $gm_mercReq = isset($request->guiaMaster->mercancia) ? $request->guiaMaster->mercancia : NULL;
        $gm_merc_vinReq = isset($request->guiaMaster->mercancia->vin) ? $request->guiaMaster->mercancia->vin : NULL;
        $gm_merc_imoReq = isset($request->guiaMaster->mercancia->imo) ? $request->guiaMaster->mercancia->imo : NULL;
        $gm_persReq = isset($request->guiaMaster->personas) ? $request->guiaMaster->personas : NULL;
        $gm_ghReq = isset($request->guiaMaster->guiaHouse) ? $request->guiaMaster->guiaHouse : NULL;
        //end Segmentación de Request----------------------------------->>>>>>>

        //Información General------------------------------------------->>>>>>>
        $ig = new informacionGeneral;
        $ig->consecutivo = isset($igReq->consecutivo) ? $igReq->consecutivo : NULL;
        $ig->idAsociado = isset($igReq->idAsociado) ? $igReq->idAsociado : NULL;
        $ig->fechaRegistro = isset($igReq->fechaRegistro) ? $igReq->fechaRegistro : NULL;
        $ig->tipoMovimiento = isset($igReq->tipoMovimiento) ? $igReq->tipoMovimiento : NULL;
        $ig->detalleMovimiento = isset($igReq->detalleMovimiento) ? $igReq->detalleMovimiento : NULL;
        $ig->tipoOperacion = isset($igReq->tipoOperacion) ? $igReq->tipoOperacion : NULL;
        $ig->cveRecintoFiscalizado = isset($igReq->cveRecintoFiscalizado) ? $igReq->cveRecintoFiscalizado : NULL;
        $ig->save();
        //end nformación General---------------------------------------->>>>>>>

        //Información de Transporte------------------------------------->>>>>>>
        $tr = new transporte;
        $tr->numeroVueloBuqueViajeImo = isset($trReq->numeroVueloBuqueViajeImo) ? $trReq->numeroVueloBuqueViajeImo : NULL;
        $tr->tipoTransporte = isset($trReq->tipoTransporte) ? $trReq->tipoTransporte : NULL;
        $tr->fechaHoraDeArribo = isset($trReq->fechaHoraDeArribo) ? $trReq->fechaHoraDeArribo : NULL;
        $tr->origenVueloBuque = isset($trReq->origenVueloBuque) ? $trReq->origenVueloBuque : NULL;
        $tr->numeroManifiesto = isset($trReq->numeroManifiesto) ? $trReq->numeroManifiesto : NULL;
        $tr->caat = isset($trReq->caat) ? $trReq->caat : NULL;
        $tr->peso = isset($trReq->peso) ? $trReq->peso : NULL;
        $tr->ump = isset($trReq->ump) ? $trReq->ump : NULL;
        $tr->piezas = isset($trReq->piezas) ? $trReq->piezas : NULL;
        $tr->idInfoGeneral = $ig->id;
        $tr->save();
        //end Información de Transporte--------------------------------->>>>>>>

        //Información Guía Master--------------------------------------->>>>>>>
        $gm = new Guia;
        $gm->numeroGuiaBl = isset($gmReq->numeroGuiaBl) ? $gmReq->numeroGuiaBl : NULL;
        $gm->caat = isset($gmReq->caat) ? $gmReq->caat : NULL;
        $gm->tipoOperacion = isset($gmReq->tipoOperacion) ? $gmReq->tipoOperacion : NULL;
        $gm->valorDeclarado = isset($gmReq->valorDeclarado) ? $gmReq->valorDeclarado : NULL;
        $gm->moneda = isset($gmReq->moneda) ? $gmReq->moneda : NULL;
        $gm->peso = isset($gmReq->peso) ? $gmReq->peso : NULL;
        $gm->ump = isset($gmReq->ump) ? $gmReq->ump : NULL;
        $gm->volumen = isset($gmReq->volumen) ? $gmReq->volumen : NULL;
        $gm->umv = isset($gmReq->uvm) ? $gmReq->uvm : NULL;
        $gm->piezas = isset($gmReq->piezas) ? $gmReq->piezas : NULL;
        $gm->idParcialidad = isset($gmReq->idParcialidad) ? $gmReq->idParcialidad : NULL;
        $gm->secuencia = isset($gmReq->secuencia) ? $gmReq->secuencia : NULL;
        $gm->observaciones = isset($gmReq->observaciones) ? $gmReq->observaciones : NULL;
        $gm->tipoGuia = 'M';
        $gm->idInfoGeneral = $ig->id;
        $gm->save();
        //end Información Guia Master----------------------------------->>>>>>>

        //Información de Mercancía Guía Master-------------------------->>>>>>>
        if(is_array($gm_mercReq))
        {
            foreach($gm_mercReq as $mercancia)
            {
                $gm_merc = new Mercancia;
                $gm_merc->secuencia = isset($mercancia->secuencia) ? $gm_merc->secuencia = $mercancia->secuencia : $gm_merc->secuencia = NULL;
                $gm_merc->pais = isset($mercancia->pais) ? $gm_merc->pais = $mercancia->pais : $gm_merc->pais = NULL;
                $gm_merc->descripcion = isset($mercancia->descripcion) ? $gm_merc->descripcion = $mercancia->descripcion : $gm_merc->descripcion = NULL;
                $gm_merc->valor = isset($mercancia->valor) ? $gm_merc->valor = $mercancia->valor : $gm_merc->valor = NULL;
                $gm_merc->moneda = isset($mercancia->moneda) ? $gm_merc->moneda = $mercancia->moneda : $gm_merc->moneda = NULL;
                $gm_merc->cantidad = isset($mercancia->cantidad) ? $gm_merc->cantidad = $mercancia->cantidad : $gm_merc->cantidad = NULL;
                $gm_merc->umc = isset($mercancia->umc) ? $gm_merc->umc = $mercancia->umc : $gm_merc->umc = NULL;
                $gm_merc->peso = isset($mercancia->peso) ? $gm_merc->peso = $mercancia->peso : $gm_merc->peso = NULL;
                $gm_merc->ump = isset($mercancia->ump) ? $gm_merc->ump = $mercancia->ump : $gm_merc->ump = NULL;
                $gm_merc->volumen = isset($mercancia->volumen) ? $gm_merc->volumen = $mercancia->volumen : $gm_merc->volumen = NULL;
                $gm_merc->observaciones = isset($mercancia->observaciones) ? $gm_merc->observaciones = $mercancia->observaciones : $gm_merc->observaciones = NULL;
                $gm_merc->idGuia = $gm->id;
                $gm_merc->save();
            }
        }
        else if($gm_mercReq != NULL)
        {
            $gm_merc = new Mercancia;
            $gm_merc->secuencia = isset($gm_mercReq->secuencia) ? $gm_merc->secuencia = $gm_mercReq->secuencia : $gm_merc->secuencia = NULL;
            $gm_merc->pais = isset($gm_mercReq->pais) ? $gm_merc->pais = $gm_mercReq->pais : $gm_merc->pais = NULL;
            $gm_merc->descripcion = isset($gm_mercReq->descripcion) ? $gm_merc->descripcion = $gm_mercReq->descripcion : $gm_merc->descripcion = NULL;
            $gm_merc->valor = isset($gm_mercReq->valor) ? $gm_merc->valor = $gm_mercReq->valor : $gm_merc->valor = NULL;
            $gm_merc->moneda = isset($gm_mercReq->moneda) ? $gm_merc->moneda = $gm_mercReq->moneda : $gm_merc->moneda = NULL;
            $gm_merc->cantidad = isset($gm_mercReq->cantidad) ? $gm_merc->cantidad = $gm_mercReq->cantidad : $gm_merc->cantidad = NULL;
            $gm_merc->umc = isset($gm_mercReq->umc) ? $gm_merc->umc = $gm_mercReq->umc : $gm_merc->umc = NULL;
            $gm_merc->peso = isset($gm_mercReq->peso) ? $gm_merc->peso = $gm_mercReq->peso : $gm_merc->peso = NULL;
            $gm_merc->ump = isset($gm_mercReq->ump) ? $gm_merc->ump = $gm_mercReq->ump : $gm_merc->ump = NULL;
            $gm_merc->volumen = isset($gm_mercReq->volumen) ? $gm_merc->volumen = $gm_mercReq->volumen : $gm_merc->volumen = NULL;
            $gm_merc->observaciones = isset($gm_mercReq->observaciones) ? $gm_merc->observaciones = $gm_mercReq->observaciones : $gm_merc->observaciones = NULL;
            $gm_merc->idGuia = $gm->id;
            $gm_merc->save();

            //Información de Vins a nivel de Master
            if(is_array($gm_merc_vinReq))
            {
                foreach($gm_merc_vinReq as $vin)
                {
                    $gm_merc_vin = new Vin;
                    $gm_merc_vin->vin = $vin->vin;
                    $gm_merc_vin->idMercancia = $gm_merc->id;
                    $gm_merc_vin->save();
                }
            }
            else if($gm_merc_vinReq != NULL)
            {
                $gm_merc_vin = new Vin;
                $gm_merc_vin->vin = $gm_merc_vinReq->vin;
                $gm_merc_vin->idMercancia = $gm_merc->id;
                $gm_merc_vin->save();
            }

            //Información de Imos a nivel de Master
            if(is_array($gm_merc_imoReq))
            {
                foreach($gm_merc_imoReq as $imo)
                {
                    $gm_merc_imo = new Imo;
                    $gm_merc_imo->imo = $imo->imo;
                    $gm_merc_imo->idMercancia = $gm_merc->id;
                    $gm_merc_imo->save();
                }
            }
            else if($gm_merc_imoReq != NULL)
            {
                $gm_merc_imo = new Imo;
                $gm_merc_imo->imo = $gm_merc_imoReq->imo;
                $gm_merc_imo->idMercancia = $gm_merc->id;
                $gm_merc_imo->save();
            }

        }
        //end Información de Mercancía Guía Master---------------------->>>>>>>

        //Información de Personas Guía Master--------------------------->>>>>>>
        if(is_array($gm_persReq))
        {
            foreach($gm_persReq as $persona)
            {
                $gmp = new Personas;
                $gmp->tipoPersona = isset($persona->tipoPersona) ? $gmp->tipoPersona = $persona->tipoPersona : $gmp->tipoPersona = NULL;
                $gmp->nombre = isset($persona->nombre) ? $gmp->nombre = $persona->nombre : $gmp->nombre = NULL;
                $gmp->calleDomicilio = isset($persona->calleDomicilio) ? $gmp->calleDomicilio = $persona->calleDomicilio : $gmp->calleDomicilio = NULL;
                $gmp->numeroInterior = isset($persona->numeroInterior) ? $gmp->numeroInterior = $persona->numeroInterior : $gmp->numeroInterior = NULL;
                $gmp->numeroExterior = isset($persona->numeroExterior) ? $gmp->numeroExterior = $persona->numeroExterior : $gmp->numeroExterior = NULL;
                $gmp->cp = isset($persona->cp) ? $gmp->cp = $persona->cp : $gmp->cp = NULL;
                $gmp->municipio = isset($persona->municipio) ? $gmp->municipio = $persona->municipio : $gmp->municipio = NULL;
                $gmp->entidadFederativa = isset($persona->entidadFederativa) ? $gmp->entidadFederativa = $persona->entidadFederativa : $gmp->entidadFederativa = NULL;
                $gmp->pais = isset($persona->pais) ? $gmp->pais = $persona->pais : $gmp->pais = NULL;
                $gmp->rfcOTaxId = isset($persona->rfcOTaxId) ? $gmp->rfcOTaxId = $persona->rfcOTaxId : $gmp->rfcOTaxId = NULL;
                $gmp->correoElectronico = isset($persona->correoElectronico) ? $gmp->correoElectronico = $persona->correoElectronico : $gmp->correoElectronico = NULL;
                $gmp->ciudad = isset($persona->ciudad) ? $gmp->ciudad = $persona->ciudad : $gmp->ciudad = NULL;
                $gmp->contacto = isset($persona->contacto) ? $gmp->contacto = $persona->contacto : $gmp->contacto = NULL;
                $gmp->telefono = isset($persona->telefono) ? $gmp->telefono = $persona->telefono : $gmp->telefono = NULL;
                $gmp->correoContacto = isset($persona->correoContacto) ? $gmp->correoContacto = $persona->correoContacto : $gmp->correoContacto = NULL;
                $gmp->idGuia = $gm->id;
                $gmp->save();
            }
        }
        else if($gm_persReq != NULL)
        {
            $gmp = new Personas;
            $gmp->tipoPersona = isset($gm_persReq->tipoPersona) ? $gmp->tipoPersona = $gm_persReq->tipoPersona : $gmp->tipoPersona = NULL;
            $gmp->nombre = isset($gm_persReq->nombre) ? $gmp->nombre = $gm_persReq->nombre : $gmp->nombre = NULL;
            $gmp->calleDomicilio = isset($gm_persReq->calleDomicilio) ? $gmp->calleDomicilio = $gm_persReq->calleDomicilio : $gmp->calleDomicilio = NULL;
            $gmp->numeroInterior = isset($gm_persReq->numeroInterior) ? $gmp->numeroInterior = $gm_persReq->numeroInterior : $gmp->numeroInterior = NULL;
            $gmp->numeroExterior = isset($gm_persReq->numeroExterior) ? $gmp->numeroExterior = $gm_persReq->numeroExterior : $gmp->numeroExterior = NULL;
            $gmp->cp = isset($gm_persReq->cp) ? $gmp->cp = $gm_persReq->cp : $gmp->cp = NULL;
            $gmp->municipio = isset($gm_persReq->municipio) ? $gmp->municipio = $gm_persReq->municipio : $gmp->municipio = NULL;
            $gmp->entidadFederativa = isset($gm_persReq->entidadFederativa) ? $gmp->entidadFederativa = $gm_persReq->entidadFederativa : $gmp->entidadFederativa = NULL;
            $gmp->pais = isset($gm_persReq->pais) ? $gmp->pais = $gm_persReq->pais : $gmp->pais = NULL;
            $gmp->rfcOTaxId = isset($gm_persReq->rfcOTaxId) ? $gmp->rfcOTaxId = $gm_persReq->rfcOTaxId : $gmp->rfcOTaxId = NULL;
            $gmp->correoElectronico = isset($gm_persReq->correoElectronico) ? $gmp->correoElectronico = $gm_persReq->correoElectronico : $gmp->correoElectronico = NULL;
            $gmp->ciudad = isset($gm_persReq->ciudad) ? $gmp->ciudad = $gm_persReq->ciudad : $gmp->ciudad = NULL;
            $gmp->contacto = isset($gm_persReq->contacto) ? $gmp->contacto = $gm_persReq->contacto : $gmp->contacto = NULL;
            $gmp->telefono = isset($gm_persReq->telefono) ? $gmp->telefono = $gm_persReq->telefono : $gmp->telefono = NULL;
            $gmp->correoContacto = isset($gm_persReq->correoContacto) ? $gmp->correoContacto = $gm_persReq->correoContacto : $gmp->correoContacto = NULL;
            $gmp->idGuia = $gm->id;
            $gmp->save();
        }
        //end Información de Personas Guía Master----------------------->>>>>>>

        //Información Guía House---------------------------------------->>>>>>>
        if(is_array($gm_ghReq))
        {
            foreach($gm_ghReq as $guiaHouse)
            {
                $gh = new Guia;
                $gh->numeroGuiaBl = isset($guiaHouse->numeroGuiaBl) ? $guiaHouse->numeroGuiaBl : NULL;
                $gh->caat = isset($guiaHouse->caat) ? $guiaHouse->caat : NULL;
                $gh->tipoOperacion = isset($guiaHouse->tipoOperacion) ? $guiaHouse->tipoOperacion : NULL;
                $gh->valorDeclarado = isset($guiaHouse->valorDeclarado) ? $guiaHouse->valorDeclarado : NULL;
                $gh->moneda = isset($guiaHouse->moneda) ? $guiaHouse->moneda : NULL;
                $gh->peso = isset($guiaHouse->peso) ? $guiaHouse->peso : NULL;
                $gh->ump = isset($guiaHouse->ump) ? $guiaHouse->ump : NULL;
                $gh->volumen = isset($guiaHouse->volumen) ? $guiaHouse->volumen : NULL;
                $gh->umv = isset($guiaHouse->uvm) ? $guiaHouse->uvm : NULL;
                $gh->piezas = isset($guiaHouse->piezas) ? $guiaHouse->piezas : NULL;
                $gh->idParcialidad = isset($guiaHouse->idParcialidad) ? $guiaHouse->idParcialidad : NULL;
                $gh->secuencia = isset($guiaHouse->secuencia) ? $guiaHouse->secuencia : NULL;
                $gh->observaciones = isset($guiaHouse->observaciones) ? $guiaHouse->observaciones : NULL;
                $gh->tipoGuia = 'H';
                $gh->idMaster = $gm->id;
                $gh->idInfoGeneral = $ig->id;
                $gh->save();

                //Información de Mercancía Guía House------------------->>>>>>>
                $gm_gh_mercReq = isset($guiaHouse->mercancia) ? $guiaHouse->mercancia : NULL;
                if(is_array($gm_gh_mercReq))
                {
                    foreach($gm_gh_mercReq as $mercancia)
                    {
                        $gh_merc = new Mercancia;
                        $gh_merc->secuencia = isset($mercancia->secuencia) ? $gh_merc->secuencia = $mercancia->secuencia : $gh_merc->secuencia = NULL;
                        $gh_merc->pais = isset($mercancia->pais) ? $gh_merc->pais = $mercancia->pais : $gh_merc->pais = NULL;
                        $gh_merc->descripcion = isset($mercancia->descripcion) ? $gh_merc->descripcion = $mercancia->descripcion : $gh_merc->descripcion = NULL;
                        $gh_merc->valor = isset($mercancia->valor) ? $gh_merc->valor = $mercancia->valor : $gh_merc->valor = NULL;
                        $gh_merc->moneda = isset($mercancia->moneda) ? $gh_merc->moneda = $mercancia->moneda : $gh_merc->moneda = NULL;
                        $gh_merc->cantidad = isset($mercancia->cantidad) ? $gh_merc->cantidad = $mercancia->cantidad : $gh_merc->cantidad = NULL;
                        $gh_merc->umc = isset($mercancia->umc) ? $gh_merc->umc = $mercancia->umc : $gh_merc->umc = NULL;
                        $gh_merc->peso = isset($mercancia->peso) ? $gh_merc->peso = $mercancia->peso : $gh_merc->peso = NULL;
                        $gh_merc->ump = isset($mercancia->ump) ? $gh_merc->ump = $mercancia->ump : $gh_merc->ump = NULL;
                        $gh_merc->volumen = isset($mercancia->volumen) ? $gh_merc->volumen = $mercancia->volumen : $gh_merc->volumen = NULL;
                        $gh_merc->observaciones = isset($mercancia->observaciones) ? $gh_merc->observaciones = $mercancia->observaciones : $gh_merc->observaciones = NULL;
                        $gh_merc->idGuia = $gh->id;
                        $gh_merc->save();

                        $gm_gh_merc_vinReq = isset($mercancia->vin) ? $mercancia->vin : NULL;
                        //Información de Vins a nivel de House
                        if(is_array($gm_gh_merc_vinReq))
                        {
                            foreach($gm_gh_merc_vinReq as $vin)
                            {
                                $gm_gh_merc_vin = new Vin;
                                $gm_gh_merc_vin->vin = $vin->vin;
                                $gm_gh_merc_vin->idMercancia = $gh_merc->id;
                                $gm_gh_merc_vin->save();
                            }
                        }
                        else if($gm_gh_merc_vinReq != NULL)
                        {
                            $gm_gh_merc_vin = new Vin;
                            $gm_gh_merc_vin->vin = $gm_gh_merc_vinReq->vin;
                            $gm_gh_merc_vin->idMercancia = $gh_merc->id;
                            $gm_gh_merc_vin->save();
                        }

                        $gm_gh_merc_imoReq = isset($mercancia->imo) ? $mercancia->imo : NULL;
                        //Información de Imos a nivel de House
                        if(is_array($gm_gh_merc_imoReq))
                        {
                            foreach($gm_gh_merc_imoReq as $imo)
                            {
                                $gm_gh_merc_imo = new Imo;
                                $gm_gh_merc_imo->imo = $imo->imo;
                                $gm_gh_merc_imo->idMercancia = $gh_merc->id;
                                $gm_gh_merc_imo->save();
                            }
                        }
                        else if($gm_gh_merc_imoReq != NULL)
                        {
                            $gm_gh_merc_imo = new Imo;
                            $gm_gh_merc_imo->imo = $gm_gh_merc_imoReq->imo;
                            $gm_gh_merc_imo->idMercancia = $gh_merc->id;
                            $gm_gh_merc_imo->save();
                        }
                    }
                }
                else if($gm_gh_mercReq != NULL)
                {
                    $gh_merc = new Mercancia;
                    $gh_merc->secuencia = isset($gm_gh_mercReq->secuencia) ? $gh_merc->secuencia = $gm_gh_mercReq->secuencia : $gh_merc->secuencia = NULL;
                    $gh_merc->pais = isset($gm_gh_mercReq->pais) ? $gh_merc->pais = $gm_gh_mercReq->pais : $gh_merc->pais = NULL;
                    $gh_merc->descripcion = isset($gm_gh_mercReq->descripcion) ? $gh_merc->descripcion = $gm_gh_mercReq->descripcion : $gh_merc->descripcion = NULL;
                    $gh_merc->valor = isset($gm_gh_mercReq->valor) ? $gh_merc->valor = $gm_gh_mercReq->valor : $gh_merc->valor = NULL;
                    $gh_merc->moneda = isset($gm_gh_mercReq->moneda) ? $gh_merc->moneda = $gm_gh_mercReq->moneda : $gh_merc->moneda = NULL;
                    $gh_merc->cantidad = isset($gm_gh_mercReq->cantidad) ? $gh_merc->cantidad = $gm_gh_mercReq->cantidad : $gh_merc->cantidad = NULL;
                    $gh_merc->umc = isset($gm_gh_mercReq->umc) ? $gh_merc->umc = $gm_gh_mercReq->umc : $gh_merc->umc = NULL;
                    $gh_merc->peso = isset($gm_gh_mercReq->peso) ? $gh_merc->peso = $gm_gh_mercReq->peso : $gh_merc->peso = NULL;
                    $gh_merc->ump = isset($gm_gh_mercReq->ump) ? $gh_merc->ump = $gm_gh_mercReq->ump : $gh_merc->ump = NULL;
                    $gh_merc->volumen = isset($gm_gh_mercReq->volumen) ? $gh_merc->volumen = $gm_gh_mercReq->volumen : $gh_merc->volumen = NULL;
                    $gh_merc->observaciones = isset($gm_gh_mercReq->observaciones) ? $gh_merc->observaciones = $gm_gh_mercReq->observaciones : $gh_merc->observaciones = NULL;
                    $gh_merc->idGuia = $gh->id;
                    $gh_merc->save();

                    $gm_gh_merc_vinReq = isset($gm_gh_mercReq->vin) ? $gm_gh_mercReq->vin : NULL;
                    //Información de Vins a nivel de House
                    if(is_array($gm_gh_merc_vinReq))
                    {
                        foreach($gm_gh_merc_vinReq as $vin)
                        {
                            $gm_gh_merc_vin = new Vin;
                            $gm_gh_merc_vin->vin = $vin->vin;
                            $gm_gh_merc_vin->idMercancia = $gh_merc->id;
                            $gm_gh_merc_vin->save();
                        }
                    }
                    else if($gm_gh_merc_vinReq != NULL)
                    {
                        $gm_gh_merc_vin = new Vin;
                        $gm_gh_merc_vin->vin = $gm_gh_merc_vinReq->vin;
                        $gm_gh_merc_vin->idMercancia = $gh_merc->id;
                        $gm_gh_merc_vin->save();
                    }

                    $gm_gh_merc_imoReq = isset($gm_gh_mercReq->imo) ? $gm_gh_mercReq->imo : NULL;
                    //Información de Imos a nivel de House
                    if(is_array($gm_gh_merc_imoReq))
                    {
                        foreach($gm_gh_merc_imoReq as $imo)
                        {
                            $gm_gh_merc_imo = new Imo;
                            $gm_gh_merc_imo->imo = $imo->imo;
                            $gm_gh_merc_imo->idMercancia = $gh_merc->id;
                            $gm_gh_merc_imo->save();
                        }
                    }
                    else if($gm_gh_merc_imoReq != NULL)
                    {
                        $gm_gh_merc_imo = new Imo;
                        $gm_gh_merc_imo->imo = $gm_gh_merc_imoReq->imo;
                        $gm_gh_merc_imo->idMercancia = $gh_merc->id;
                        $gm_gh_merc_imo->save();
                    }

                }
                //end Información de Mercancía Guía House--------------->>>>>>>

                //Información de Personas Guía House-------------------->>>>>>>
                $gm_gh_persReq = isset($guiaHouse->personas) ? $guiaHouse->personas : NULL;
                if(is_array($gm_gh_persReq))
                {
                    foreach($gm_gh_persReq as $persona)
                    {
                        $ghp = new Personas;
                        $ghp->tipoPersona = isset($persona->tipoPersona) ? $ghp->tipoPersona = $persona->tipoPersona : $ghp->tipoPersona = NULL;
                        $ghp->nombre = isset($persona->nombre) ? $ghp->nombre = $persona->nombre : $ghp->nombre = NULL;
                        $ghp->calleDomicilio = isset($persona->calleDomicilio) ? $ghp->calleDomicilio = $persona->calleDomicilio : $ghp->calleDomicilio = NULL;
                        $ghp->numeroInterior = isset($persona->numeroInterior) ? $ghp->numeroInterior = $persona->numeroInterior : $ghp->numeroInterior = NULL;
                        $ghp->numeroExterior = isset($persona->numeroExterior) ? $ghp->numeroExterior = $persona->numeroExterior : $ghp->numeroExterior = NULL;
                        $ghp->cp = isset($persona->cp) ? $ghp->cp = $persona->cp : $ghp->cp = NULL;
                        $ghp->municipio = isset($persona->municipio) ? $ghp->municipio = $persona->municipio : $ghp->municipio = NULL;
                        $ghp->entidadFederativa = isset($persona->entidadFederativa) ? $ghp->entidadFederativa = $persona->entidadFederativa : $ghp->entidadFederativa = NULL;
                        $ghp->pais = isset($persona->pais) ? $ghp->pais = $persona->pais : $ghp->pais = NULL;
                        $ghp->rfcOTaxId = isset($persona->rfcOTaxId) ? $ghp->rfcOTaxId = $persona->rfcOTaxId : $ghp->rfcOTaxId = NULL;
                        $ghp->correoElectronico = isset($persona->correoElectronico) ? $ghp->correoElectronico = $persona->correoElectronico : $ghp->correoElectronico = NULL;
                        $ghp->ciudad = isset($persona->ciudad) ? $ghp->ciudad = $persona->ciudad : $ghp->ciudad = NULL;
                        $ghp->contacto = isset($persona->contacto) ? $ghp->contacto = $persona->contacto : $ghp->contacto = NULL;
                        $ghp->telefono = isset($persona->telefono) ? $ghp->telefono = $persona->telefono : $ghp->telefono = NULL;
                        $ghp->correoContacto = isset($persona->correoContacto) ? $ghp->correoContacto = $persona->correoContacto : $ghp->correoContacto = NULL;
                        $ghp->idGuia = $gh->id;
                        $ghp->save();
                    }
                }
                else if($gm_gh_persReq != NULL)
                {
                    $ghp = new Personas;
                    $ghp->tipoPersona = isset($gm_gh_persReq->tipoPersona) ? $ghp->tipoPersona = $gm_gh_persReq->tipoPersona : $ghp->tipoPersona = NULL;
                    $ghp->nombre = isset($gm_gh_persReq->nombre) ? $ghp->nombre = $gm_gh_persReq->nombre : $ghp->nombre = NULL;
                    $ghp->calleDomicilio = isset($gm_gh_persReq->calleDomicilio) ? $ghp->calleDomicilio = $gm_gh_persReq->calleDomicilio : $ghp->calleDomicilio = NULL;
                    $ghp->numeroInterior = isset($gm_gh_persReq->numeroInterior) ? $ghp->numeroInterior = $gm_gh_persReq->numeroInterior : $ghp->numeroInterior = NULL;
                    $ghp->numeroExterior = isset($gm_gh_persReq->numeroExterior) ? $ghp->numeroExterior = $gm_gh_persReq->numeroExterior : $ghp->numeroExterior = NULL;
                    $ghp->cp = isset($gm_gh_persReq->cp) ? $ghp->cp = $gm_gh_persReq->cp : $ghp->cp = NULL;
                    $ghp->municipio = isset($gm_gh_persReq->municipio) ? $ghp->municipio = $gm_gh_persReq->municipio : $ghp->municipio = NULL;
                    $ghp->entidadFederativa = isset($gm_gh_persReq->entidadFederativa) ? $ghp->entidadFederativa = $gm_gh_persReq->entidadFederativa : $ghp->entidadFederativa = NULL;
                    $ghp->pais = isset($gm_gh_persReq->pais) ? $ghp->pais = $gm_gh_persReq->pais : $ghp->pais = NULL;
                    $ghp->rfcOTaxId = isset($gm_gh_persReq->rfcOTaxId) ? $ghp->rfcOTaxId = $gm_gh_persReq->rfcOTaxId : $ghp->rfcOTaxId = NULL;
                    $ghp->correoElectronico = isset($gm_gh_persReq->correoElectronico) ? $ghp->correoElectronico = $gm_gh_persReq->correoElectronico : $ghp->correoElectronico = NULL;
                    $ghp->ciudad = isset($gm_gh_persReq->ciudad) ? $ghp->ciudad = $gm_gh_persReq->ciudad : $ghp->ciudad = NULL;
                    $ghp->contacto = isset($gm_gh_persReq->contacto) ? $ghp->contacto = $gm_gh_persReq->contacto : $ghp->contacto = NULL;
                    $ghp->telefono = isset($gm_gh_persReq->telefono) ? $ghp->telefono = $gm_gh_persReq->telefono : $ghp->telefono = NULL;
                    $ghp->correoContacto = isset($gm_gh_persReq->correoContacto) ? $ghp->correoContacto = $gm_gh_persReq->correoContacto : $ghp->correoContacto = NULL;
                    $ghp->idGuia = $gh->id;
                    $ghp->save();
                }
                //end Información de Personas Guía House---------------->>>>>>>
            }
        }
        else if($gm_ghReq != NULL)
        {
            $gh = new Guia;
            $gh->numeroGuiaBl = isset($gm_ghReq->numeroGuiaBl) ? $gm_ghReq->numeroGuiaBl : NULL;
            $gh->caat = isset($gm_ghReq->caat) ? $gm_ghReq->caat : NULL;
            $gh->tipoOperacion = isset($gm_ghReq->tipoOperacion) ? $gm_ghReq->tipoOperacion : NULL;
            $gh->valorDeclarado = isset($gm_ghReq->valorDeclarado) ? $gm_ghReq->valorDeclarado : NULL;
            $gh->moneda = isset($gm_ghReq->moneda) ? $gm_ghReq->moneda : NULL;
            $gh->peso = isset($gm_ghReq->peso) ? $gm_ghReq->peso : NULL;
            $gh->ump = isset($gm_ghReq->ump) ? $gm_ghReq->ump : NULL;
            $gh->volumen = isset($gm_ghReq->volumen) ? $gm_ghReq->volumen : NULL;
            $gh->umv = isset($gm_ghReq->uvm) ? $gm_ghReq->uvm : NULL;
            $gh->piezas = isset($gm_ghReq->piezas) ? $gm_ghReq->piezas : NULL;
            $gh->idParcialidad = isset($gm_ghReq->idParcialidad) ? $gm_ghReq->idParcialidad : NULL;
            $gh->secuencia = isset($gm_ghReq->secuencia) ? $gm_ghReq->secuencia : NULL;
            $gh->observaciones = isset($gm_ghReq->observaciones) ? $gm_ghReq->observaciones : NULL;
            $gh->tipoGuia = 'H';
            $gh->idMaster = $gm->id;
            $gh->idInfoGeneral = $ig->id;
            $gh->save();

            //Información de Mercancía Guía House----------------------->>>>>>>
            $gm_gh_mercReq = isset($gm_ghReq->mercancia) ? $gm_ghReq->mercancia : NULL;
            if(is_array($gm_gh_mercReq))
            {
                foreach($gm_gh_mercReq as $mercancia)
                {
                    $gh_merc = new Mercancia;
                    $gh_merc->secuencia = isset($mercancia->secuencia) ? $gh_merc->secuencia = $mercancia->secuencia : $gh_merc->secuencia = NULL;
                    $gh_merc->pais = isset($mercancia->pais) ? $gh_merc->pais = $mercancia->pais : $gh_merc->pais = NULL;
                    $gh_merc->descripcion = isset($mercancia->descripcion) ? $gh_merc->descripcion = $mercancia->descripcion : $gh_merc->descripcion = NULL;
                    $gh_merc->valor = isset($mercancia->valor) ? $gh_merc->valor = $mercancia->valor : $gh_merc->valor = NULL;
                    $gh_merc->moneda = isset($mercancia->moneda) ? $gh_merc->moneda = $mercancia->moneda : $gh_merc->moneda = NULL;
                    $gh_merc->cantidad = isset($mercancia->cantidad) ? $gh_merc->cantidad = $mercancia->cantidad : $gh_merc->cantidad = NULL;
                    $gh_merc->umc = isset($mercancia->umc) ? $gh_merc->umc = $mercancia->umc : $gh_merc->umc = NULL;
                    $gh_merc->peso = isset($mercancia->peso) ? $gh_merc->peso = $mercancia->peso : $gh_merc->peso = NULL;
                    $gh_merc->ump = isset($mercancia->ump) ? $gh_merc->ump = $mercancia->ump : $gh_merc->ump = NULL;
                    $gh_merc->volumen = isset($mercancia->volumen) ? $gh_merc->volumen = $mercancia->volumen : $gh_merc->volumen = NULL;
                    $gh_merc->observaciones = isset($mercancia->observaciones) ? $gh_merc->observaciones = $mercancia->observaciones : $gh_merc->observaciones = NULL;
                    $gh_merc->idGuia = $gh->id;
                    $gh_merc->save();

                    $gm_gh_merc_vinReq = isset($mercancia->vin) ? $mercancia->vin : NULL;
                    //Información de Vins a nivel de House
                    if(is_array($gm_gh_merc_vinReq))
                    {
                        foreach($gm_gh_merc_vinReq as $vin)
                        {
                            $gm_gh_merc_vin = new Vin;
                            $gm_gh_merc_vin->vin = $vin->vin;
                            $gm_gh_merc_vin->idMercancia = $gh_merc->id;
                            $gm_gh_merc_vin->save();
                        }
                    }
                    else if($gm_gh_merc_vinReq != NULL)
                    {
                        $gm_gh_merc_vin = new Vin;
                        $gm_gh_merc_vin->vin = $gm_gh_merc_vinReq->vin;
                        $gm_gh_merc_vin->idMercancia = $gh_merc->id;
                        $gm_gh_merc_vin->save();
                    }

                    $gm_gh_merc_imoReq = isset($mercancia->imo) ? $mercancia->imo : NULL;
                    //Información de Imos a nivel de House
                    if(is_array($gm_gh_merc_imoReq))
                    {
                        foreach($gm_gh_merc_imoReq as $imo)
                        {
                            $gm_gh_merc_imo = new Imo;
                            $gm_gh_merc_imo->imo = $imo->imo;
                            $gm_gh_merc_imo->idMercancia = $gh_merc->id;
                            $gm_gh_merc_imo->save();
                        }
                    }
                    else if($gm_gh_merc_imoReq != NULL)
                    {
                        $gm_gh_merc_imo = new Imo;
                        $gm_gh_merc_imo->imo = $gm_gh_merc_imoReq->imo;
                        $gm_gh_merc_imo->idMercancia = $gh_merc->id;
                        $gm_gh_merc_imo->save();
                    }
                }
            }
            else if($gm_gh_mercReq != NULL)
            {
                $gh_merc = new Mercancia;
                $gh_merc->secuencia = isset($gm_gh_mercReq->secuencia) ? $gh_merc->secuencia = $gm_gh_mercReq->secuencia : $gh_merc->secuencia = NULL;
                $gh_merc->pais = isset($gm_gh_mercReq->pais) ? $gh_merc->pais = $gm_gh_mercReq->pais : $gh_merc->pais = NULL;
                $gh_merc->descripcion = isset($gm_gh_mercReq->descripcion) ? $gh_merc->descripcion = $gm_gh_mercReq->descripcion : $gh_merc->descripcion = NULL;
                $gh_merc->valor = isset($gm_gh_mercReq->valor) ? $gh_merc->valor = $gm_gh_mercReq->valor : $gh_merc->valor = NULL;
                $gh_merc->moneda = isset($gm_gh_mercReq->moneda) ? $gh_merc->moneda = $gm_gh_mercReq->moneda : $gh_merc->moneda = NULL;
                $gh_merc->cantidad = isset($gm_gh_mercReq->cantidad) ? $gh_merc->cantidad = $gm_gh_mercReq->cantidad : $gh_merc->cantidad = NULL;
                $gh_merc->umc = isset($gm_gh_mercReq->umc) ? $gh_merc->umc = $gm_gh_mercReq->umc : $gh_merc->umc = NULL;
                $gh_merc->peso = isset($gm_gh_mercReq->peso) ? $gh_merc->peso = $gm_gh_mercReq->peso : $gh_merc->peso = NULL;
                $gh_merc->ump = isset($gm_gh_mercReq->ump) ? $gh_merc->ump = $gm_gh_mercReq->ump : $gh_merc->ump = NULL;
                $gh_merc->volumen = isset($gm_gh_mercReq->volumen) ? $gh_merc->volumen = $gm_gh_mercReq->volumen : $gh_merc->volumen = NULL;
                $gh_merc->observaciones = isset($gm_gh_mercReq->observaciones) ? $gh_merc->observaciones = $gm_gh_mercReq->observaciones : $gh_merc->observaciones = NULL;
                $gh_merc->idGuia = $gh->id;
                $gh_merc->save();

                $gm_gh_merc_vinReq = isset($gm_gh_mercReq->vin) ? $gm_gh_mercReq->vin : NULL;
                //Información de Vins a nivel de House
                if(is_array($gm_gh_merc_vinReq))
                {
                    foreach($gm_gh_merc_vinReq as $vin)
                    {
                        $gm_gh_merc_vin = new Vin;
                        $gm_gh_merc_vin->vin = $vin->vin;
                        $gm_gh_merc_vin->idMercancia = $gh_merc->id;
                        $gm_gh_merc_vin->save();
                    }
                }
                else if($gm_gh_merc_vinReq != NULL)
                {
                    $gm_gh_merc_vin = new Vin;
                    $gm_gh_merc_vin->vin = $gm_gh_merc_vinReq->vin;
                    $gm_gh_merc_vin->idMercancia = $gh_merc->id;
                    $gm_gh_merc_vin->save();
                }

                $gm_gh_merc_imoReq = isset($gm_gh_mercReq->imo) ? $gm_gh_mercReq->imo : NULL;
                //Información de Imos a nivel de House
                if(is_array($gm_gh_merc_imoReq))
                {
                    foreach($gm_gh_merc_imoReq as $imo)
                    {
                        $gm_gh_merc_imo = new Imo;
                        $gm_gh_merc_imo->imo = $imo->imo;
                        $gm_gh_merc_imo->idMercancia = $gh_merc->id;
                        $gm_gh_merc_imo->save();
                    }
                }
                else if($gm_gh_merc_imoReq != NULL)
                {
                    $gm_gh_merc_imo = new Imo;
                    $gm_gh_merc_imo->imo = $gm_gh_merc_imoReq->imo;
                    $gm_gh_merc_imo->idMercancia = $gh_merc->id;
                    $gm_gh_merc_imo->save();
                }

            }
            //end Información de Mercancía Guía House------------------->>>>>>>

            //Información de Personas Guía House------------------------>>>>>>>
            $gm_gh_persReq = isset($gm_ghReq->personas) ? $gm_ghReq->personas : NULL;
            if(is_array($gm_gh_persReq))
            {
                foreach($gm_gh_persReq as $persona)
                {
                    $ghp = new Personas;
                    $ghp->tipoPersona = isset($persona->tipoPersona) ? $ghp->tipoPersona = $persona->tipoPersona : $ghp->tipoPersona = NULL;
                    $ghp->nombre = isset($persona->nombre) ? $ghp->nombre = $persona->nombre : $ghp->nombre = NULL;
                    $ghp->calleDomicilio = isset($persona->calleDomicilio) ? $ghp->calleDomicilio = $persona->calleDomicilio : $ghp->calleDomicilio = NULL;
                    $ghp->numeroInterior = isset($persona->numeroInterior) ? $ghp->numeroInterior = $persona->numeroInterior : $ghp->numeroInterior = NULL;
                    $ghp->numeroExterior = isset($persona->numeroExterior) ? $ghp->numeroExterior = $persona->numeroExterior : $ghp->numeroExterior = NULL;
                    $ghp->cp = isset($persona->cp) ? $ghp->cp = $persona->cp : $ghp->cp = NULL;
                    $ghp->municipio = isset($persona->municipio) ? $ghp->municipio = $persona->municipio : $ghp->municipio = NULL;
                    $ghp->entidadFederativa = isset($persona->entidadFederativa) ? $ghp->entidadFederativa = $persona->entidadFederativa : $ghp->entidadFederativa = NULL;
                    $ghp->pais = isset($persona->pais) ? $ghp->pais = $persona->pais : $ghp->pais = NULL;
                    $ghp->rfcOTaxId = isset($persona->rfcOTaxId) ? $ghp->rfcOTaxId = $persona->rfcOTaxId : $ghp->rfcOTaxId = NULL;
                    $ghp->correoElectronico = isset($persona->correoElectronico) ? $ghp->correoElectronico = $persona->correoElectronico : $ghp->correoElectronico = NULL;
                    $ghp->ciudad = isset($persona->ciudad) ? $ghp->ciudad = $persona->ciudad : $ghp->ciudad = NULL;
                    $ghp->contacto = isset($persona->contacto) ? $ghp->contacto = $persona->contacto : $ghp->contacto = NULL;
                    $ghp->telefono = isset($persona->telefono) ? $ghp->telefono = $persona->telefono : $ghp->telefono = NULL;
                    $ghp->correoContacto = isset($persona->correoContacto) ? $ghp->correoContacto = $persona->correoContacto : $ghp->correoContacto = NULL;
                    $ghp->idGuia = $gh->id;
                    $ghp->save();
                }
            }
            else if($gm_gh_persReq != NULL)
            {
                $ghp = new Personas;
                $ghp->tipoPersona = isset($gm_gh_persReq->tipoPersona) ? $ghp->tipoPersona = $gm_gh_persReq->tipoPersona : $ghp->tipoPersona = NULL;
                $ghp->nombre = isset($gm_gh_persReq->nombre) ? $ghp->nombre = $gm_gh_persReq->nombre : $ghp->nombre = NULL;
                $ghp->calleDomicilio = isset($gm_gh_persReq->calleDomicilio) ? $ghp->calleDomicilio = $gm_gh_persReq->calleDomicilio : $ghp->calleDomicilio = NULL;
                $ghp->numeroInterior = isset($gm_gh_persReq->numeroInterior) ? $ghp->numeroInterior = $gm_gh_persReq->numeroInterior : $ghp->numeroInterior = NULL;
                $ghp->numeroExterior = isset($gm_gh_persReq->numeroExterior) ? $ghp->numeroExterior = $gm_gh_persReq->numeroExterior : $ghp->numeroExterior = NULL;
                $ghp->cp = isset($gm_gh_persReq->cp) ? $ghp->cp = $gm_gh_persReq->cp : $ghp->cp = NULL;
                $ghp->municipio = isset($gm_gh_persReq->municipio) ? $ghp->municipio = $gm_gh_persReq->municipio : $ghp->municipio = NULL;
                $ghp->entidadFederativa = isset($gm_gh_persReq->entidadFederativa) ? $ghp->entidadFederativa = $gm_gh_persReq->entidadFederativa : $ghp->entidadFederativa = NULL;
                $ghp->pais = isset($gm_gh_persReq->pais) ? $ghp->pais = $gm_gh_persReq->pais : $ghp->pais = NULL;
                $ghp->rfcOTaxId = isset($gm_gh_persReq->rfcOTaxId) ? $ghp->rfcOTaxId = $gm_gh_persReq->rfcOTaxId : $ghp->rfcOTaxId = NULL;
                $ghp->correoElectronico = isset($gm_gh_persReq->correoElectronico) ? $ghp->correoElectronico = $gm_gh_persReq->correoElectronico : $ghp->correoElectronico = NULL;
                $ghp->ciudad = isset($gm_gh_persReq->ciudad) ? $ghp->ciudad = $gm_gh_persReq->ciudad : $ghp->ciudad = NULL;
                $ghp->contacto = isset($gm_gh_persReq->contacto) ? $ghp->contacto = $gm_gh_persReq->contacto : $ghp->contacto = NULL;
                $ghp->telefono = isset($gm_gh_persReq->telefono) ? $ghp->telefono = $gm_gh_persReq->telefono : $ghp->telefono = NULL;
                $ghp->correoContacto = isset($gm_gh_persReq->correoContacto) ? $ghp->correoContacto = $gm_gh_persReq->correoContacto : $ghp->correoContacto = NULL;
                $ghp->idGuia = $gh->id;
                $ghp->save();
            }
            //end Información de Personas Guía House-------------------->>>>>>>

        }
        //end Información Guía House------------------------------------>>>>>>>

        //end Información Guia Master----------------------------------->>>>>>>
        if($igReq == NULL || $trReq == NULL || $gmReq == NULL){
            $soapResponse = 'Ha ocurrido un error inesperado';
        }else{
            $soapResponse = "Transmision correcta CONSECUTIVO:".$ig->consecutivo;
        }
        return $soapResponse;
    }
}
