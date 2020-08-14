# VUCEMSIRA 3.7 #

### Información del Repositorio ###

* Repositorio implementado sobre Laravel 7 + NuSoap para el consumo del servicio web VUCEM/SIRA

### Información para el desarrollo ###

![alt text](./VUCEM.png)

* Guía de Apoyo para Implementación SIRA Version 3.7 (Sección Recintos Fiscalizados)
* [Ver Detalles](https://www.ventanillaunica.gob.mx/vucem/descargas.html)

### Métodos Desarrollados ###

* NotificacionIngresoMercancia (Servidor)
    * Entrega un **idAsociado** por **Master** y un **consecutivo** por **House** así como la información manifestada por la aerolínea que debe recibir el recinto fiscalizado.
* ConsultaManifiestos (Cliente)
    * Sirve para conocer las guías máster referentes a un manifiesto declarado.
    * Ejemplo de Request (METHOD GET / URL_ENCODED):
    ```sh
    http://localhost/sira/ConsultaManifiestos?manifiesto=026200020200508FFF
    ```
* ConsultaDetalleGuia (Cliente)
    * Sirve para conocer la última infomración de las guías master declaradas en un manifiesto.
    * Ejemplo de Request (METHOD GET / URL_ENCODED):
    ```sh
    http://localhost/sira/ConsultaDetalleGuia?manifiesto=026200020200508FFF&guiaMaster=602-20200508
    ```
* IngresoSimple (Cliente)
    * Si llega la **master completa, sin guías house**, se debe utilizar **IngresoSimpleMaster**.
    * Ejemplo de Request por Guías Master (METHOD GET / URL_ENCODED):
    ```sh
    http://localhost/sira/IngresoSimple/Master?tipoOperacion=1&consecutivo=20000006Q&idAsociado=20000006Q&fechaInicioDescarga=2020-08-14T09%3A11%3A32-05%3A00&fechaFinDescarga=2020-08-14T09%3A50%3A00-05%3A00&peso=301.0&condicionCarga=1
    ```
    * Si llega la **master con guía houses completas**, se debe utilizar **IngresoSimpleHouse** en la cual se deben ingresar todas las guías house.
    * Ejemplo de Request por Guías House (METHOD GET / URL_ENCODED):
    ```sh
    http://localhost/sira/IngresoSimple/House?tipoOperacion=1&guiasHouse=TRESABRIL27%2CCUATROABRIL27%2CCINCOABRIL27&consecutivo=20000006Q&idAsociado=20000006Q&fechaInicioDescarga=2020-08-14T09%3A11%3A32-05%3A00&fechaFinDescarga=2020-08-14T09%3A50%3A00-05%3A00&peso=301.0&condicionCarga=1
    ```
* IngresoNoManifestado (Cliente)
    * Si llega una **master que no fue manifestada**, se debe utilizar **IngresoNoManifestado**
* IngresoParcial (Cliente)
    * Si llega la **master incompleta**, se debe utilizar **IngresoParcialMaster** y/o **IngresoParcialHouse** hasta completar el peso declarado en la master.

### Instalación ###

```sh
$ composer require zerobyt/sira
$ composer install
$ php artisan migrate
```
### Configuración ###

* Para configurar el webservice es necesario colocar los datos de acceso de cada recinto fiscalizado en el archivo .env

### Créditos ###

* Desarrollado por Cristian Vega @ZeroBytMx

### Licencia ###

MIT
