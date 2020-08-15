# VUCEMSIRA 3.7

## Información del Repositorio

* Repositorio implementado sobre Laravel 7 + NuSoap para el consumo del servicio web VUCEM/SIRA

## Información para el desarrollo

![alt text](./VUCEM.png)

* Guía de Apoyo para Implementación SIRA Version 3.7 (Sección Recintos Fiscalizados)
* [Ver Detalles](https://www.ventanillaunica.gob.mx/vucem/descargas.html)

## Instalación
```sh
    $ composer require zerobyt/sira
    $ composer install
    $ php artisan migrate
```
## Configuración
* Para configurar el webservice es necesario colocar los datos de acceso de cada recinto fiscalizado en el archivo .env

## Créditos
* Desarrollado por Cristian Omar Vega Mendoza @ZeroBytMx

## Licencia
* Todos los Derechos Reservados

## NotificacionIngresoMercancia (Servidor)
> Entrega un **idAsociado** por **Guía Master** y un **consecutivo** por **Guía House** así como la información manifestada por la aerolínea que debe recibir el recinto fiscalizado.
##    
* URL del Servicio
    ```sh
    http://localhost/sira/index.php?wsdl
    ```
* Método para recibir datos
    ```sh
    notificacionIngresoMercancia
    ```
    > La información que se recibe en este método puede ser consultada en la **Guía de Apoyo** publicada al inicio de este repositorio.

## ConsultaManifiestos (Cliente)
> Sirve para conocer las **Guías Master** referentes a un **Manifiesto** declarado.

* URL del Servicio
    ```sh
    http://localhost/sira/ConsultaManifiestos
    ```
* Valores requeridos
    ```sh
    manifiesto
    ```
* Ejemplo de Request (METHOD GET / URL_ENCODED):
    ```sh
    http://localhost/sira/ConsultaManifiestos?manifiesto=026200020200508FFF
    ```
## ConsultaDetalleGuia (Cliente)
> Sirve para conocer la última infomración de las **Guías Master** declaradas en un manifiesto.

* URL del Servicio
    ```sh
    http://localhost/sira/ConsultaDetalleGuia
    ```
* Valores requeridos
    ```sh
    manifiesto
    guiaMaster
    ```
* Ejemplo de Request (METHOD GET / URL_ENCODED):
    ```sh
    http://localhost/sira/ConsultaDetalleGuia?manifiesto=026200020200508FFF&guiaMaster=602-20200508
    ```
## IngresoSimple (Cliente)
> Si llega la **Guía Master** completa, sin **Guías House**, se debe utilizar **IngresoSimpleMaster**.

* URL del Servicio
    ```sh
    http://localhost/sira/IngresoSimple/Master
    ```
* Valores requeridos
    ```sh
    tipoOperacion
    consecutivo
    idAsociado
    fechaInicioDescarga
    fechaFinDescarga
    peso
    condicionCarga
    ```
* Ejemplo de Request por **Guías Master** (METHOD GET / URL_ENCODED):
    ```sh
    http://localhost/sira/IngresoSimple/Master?tipoOperacion=1&consecutivo=20000006Q&idAsociado=20000006Q&fechaInicioDescarga=2020-08-14T09%3A11%3A32-05%3A00&fechaFinDescarga=2020-08-14T09%3A50%3A00-05%3A00&peso=301.0&condicionCarga=1
    ```

> Si llega la **Guía Master** con **Guías House** completas, se debe utilizar **IngresoSimpleHouse** en la cual se deben ingresar todas las **Guías House**.

* URL del Servicio
    ```sh
    http://localhost/sira/IngresoSimple/House
    ```
* Valores requeridos
    ```sh
    tipoOperacion
    consecutivo
    idAsociado
    fechaInicioDescarga
    fechaFinDescarga
    peso
    condicionCarga
    guiasHouse
    ```
* Ejemplo de Request por **Guías House** (METHOD GET / URL_ENCODED):
    ```sh
    http://localhost/sira/IngresoSimple/House?tipoOperacion=1&guiasHouse=TRESABRIL27%2CCUATROABRIL27%2CCINCOABRIL27&consecutivo=20000006Q&idAsociado=20000006Q&fechaInicioDescarga=2020-08-14T09%3A11%3A32-05%3A00&fechaFinDescarga=2020-08-14T09%3A50%3A00-05%3A00&peso=301.0&condicionCarga=1
    ```
## IngresoParcial (Cliente)
> Si llega la **Guía Master** incompleta, sin **Guías House**, se debe utilizar **IngresoParcialMaster** hasta completar el peso declarado.

* URL del Servicio
    ```sh
    http://localhost/sira/IngresoParcial/Master
    ```
* Valores requeridos
    ```sh
    tipoOperacion
    consecutivo
    idAsociado
    tipoMercancia
    fechaInicioDescarga
    fechaFinDescarga
    peso
    numeroParcialidad
    cantidad
    condicionCarga
    ```
* Ejemplo de Request por **Guías Master** (METHOD GET / URL_ENCODED):
    ```sh
    http://localhost/sira/IngresoParcial/Master?tipoOperacion=1&consecutivo=20000006Q&idAsociado=20000006Q&fechaInicioDescarga=2020-08-14T09%3A11%3A32-05%3A00&fechaFinDescarga=2020-08-14T09%3A50%3A00-05%3A00&numeroParcialidad=1&cantidad=3&peso=301.0&condicionCarga=1
    ```
> Si llega la **Guía House** incompleta, se debe utilizar **IngresoParcialHouse** hasta completar el peso declarado.

* URL del Servicio
    ```sh
    http://localhost/sira/IngresoParcial/House
    ```
* Valores requeridos
    ```sh
    tipoOperacion
    consecutivo
    idAsociado
    guiaHouse
    tipoMercancia
    fechaInicioDescarga
    fechaFinDescarga
    peso
    numeroParcialidad
    cantidad
    condicionCarga
    ```
* Ejemplo de Request por **Guías House** (METHOD GET / URL_ENCODED):
    ```sh
    http://localhost/sira/IngresoParcial/Master?tipoOperacion=1&consecutivo=20000006Q&idAsociado=20000006Q&fechaInicioDescarga=2020-08-14T09%3A11%3A32-05%3A00&fechaFinDescarga=2020-08-14T09%3A50%3A00-05%3A00&guiaHouse=TRESABRIL27&numeroParcialidad=1&cantidad=3&peso=301.0&condicionCarga=1
    ```

## IngresoNoManifestado (Cliente)
> Si llega al **Recinto Fiscalizado** una **Guía Master** que no fue manifestada por la aerolínea, se debe utilizar **IngresoNoManifestado**
