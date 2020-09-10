<!doctype html>
<html lang="es">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta name="description" content="">
        <meta name="author" content="Cristian Omar Vega Mendoza">
        <title>Testing SIRA 3.7</title>
        <!-- Bootstrap core CSS -->
        <link href="https://getbootstrap.com/docs/4.0/dist/css/bootstrap.min.css" rel="stylesheet">
        <!--FONT AWESOME-->
        <link href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
        <!-- Custom styles for this template -->
        <link href="https://getbootstrap.com/docs/4.0/examples/checkout/form-validation.css" rel="stylesheet">
        <!-- Tempus Dominus for DateTimePicker -->
        <script type="text/javascript" src="https://code.jquery.com/jquery-3.5.1.js"></script>
        <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.22.2/moment.min.js"></script>
        <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/tempusdominus-bootstrap-4/5.0.0-alpha14/js/tempusdominus-bootstrap-4.min.js"></script>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/tempusdominus-bootstrap-4/5.0.0-alpha14/css/tempusdominus-bootstrap-4.min.css" />
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">
    </head>
    <body class="bg-light">
        <div class="container">
        <div class="py-5 text-center">
            <h2>IngresoNoManifestado</h2>
            <p class="lead">Completa los campos del formulario con los valores recibidos en la notificación de ingreso de mercancía, posteriormente hacer click en Enviar Formulario y esperar la respuesta del webservice.</p>
        </div>
        <div class="row">
            <div class="col-md-4 order-md-2 mb-4">
                <h4 class="d-flex justify-content-between align-items-center mb-3">
                    <span class="text-muted">Ingresos</span>
                </h4>
                <ul class="list-group mb-3">
                    <a href="ingresoSimpleMaster.php">
                        <li class="list-group-item d-flex justify-content-between lh-condensed">
                            <h6 class="my-0">IngresoSimpleMaster</h6>
                        </li>
                    </a>
                    <a href="ingresoSimpleHouse.php">
                        <li class="list-group-item d-flex justify-content-between lh-condensed">
                            <h6 class="my-0">IngresoSimpleHouse</h6>
                        </li>
                    </a>
                    <a href="ingresoParcialMaster.php">
                        <li class="list-group-item d-flex justify-content-between lh-condensed">
                            <h6 class="my-0">IngresoParcialMaster</h6>
                        </li>
                    </a>
                    <a href="ingresoParcialHouse.php">
                        <li class="list-group-item d-flex justify-content-between lh-condensed">
                            <h6 class="my-0">IngresoParcialHouse</h6>
                        </li>
                    </a>
                    <a href="IngresoNoManifestado.php">
                        <li class="list-group-item d-flex justify-content-between lh-condensed">
                            <h6 class="my-0">IngresoNoManifestado</h6>
                        </li>
                    </a>
                </ul>
                <h4 class="d-flex justify-content-between align-items-center mb-3">
                    <span class="text-muted">Salidas</span>
                </h4>
                <ul class="list-group mb-3">
                    <a href="SolicitudSalidaMaster.php">
                        <li class="list-group-item d-flex justify-content-between lh-condensed">
                            <h6 class="my-0">SolicitudSalidaMaster</h6>
                        </li>
                    </a>
                    <a href="ConfirmacionSalidaMaster.php">
                        <li class="list-group-item d-flex justify-content-between lh-condensed">
                            <h6 class="my-0">ConfirmacionSalidaMaster</h6>
                        </li>
                    </a>
                    <a href="SolicitudSalidaHouse.php">
                        <li class="list-group-item d-flex justify-content-between lh-condensed">
                            <h6 class="my-0">SolicitudSalidaHouse</h6>
                        </li>
                    </a>
                    <a href="ConfirmacionSalidaHouse.php">
                        <li class="list-group-item d-flex justify-content-between lh-condensed">
                            <h6 class="my-0">ConfirmacionSalidaHouse</h6>
                        </li>
                    </a>
                    <a href="Cancelaciones.php">
                        <li class="list-group-item d-flex justify-content-between lh-condensed">
                            <h6 class="my-0">Cancelaciones</h6>
                        </li>
                    </a>
                </ul>
                <h4 class="d-flex justify-content-between align-items-center mb-3">
                    <span class="text-muted">Consulta</span>
                </h4>
                <ul class="list-group mb-3">
                    <a href="ConsultaManifiestos.php">
                        <li class="list-group-item d-flex justify-content-between lh-condensed">
                            <h6 class="my-0">ConsultaManifiestos</h6>
                        </li>
                    </a>
                    <a href="ConsultaDetalleGuia.php">
                        <li class="list-group-item d-flex justify-content-between lh-condensed">
                            <h6 class="my-0">ConsultaDetalleGuia</h6>
                        </li>
                    </a>
                </ul>
            </div>
            <div class="col-md-8 order-md-1">
                <form class="needs-validation" novalidate action="../IngresoNoManifestado" method="get" enctype="multipart/form-data">

                    <h5 class="mb-3">Información General</h5>
                    <div class="row">
                        <div class="col-md-4">
                            <label for="firstName">Consecutivo</label>
                            <input type="text" class="form-control" id="consecutivo" name="informacionGeneral[consecutivo]" placeholder="" value="" required>
                            <div class="invalid-feedback">
                                El consecutivo es requerido.
                            </div>
                        </div>
                        <div class="col-md-4">
                            <label for="lastName">idAsociado</label>
                            <input type="text" class="form-control" id="idAsociado" name="informacionGeneral[idAsociado]" placeholder="" value="" required>
                            <div class="invalid-feedback">
                                El idAsociado es requerido.
                            </div>
                        </div>
                        <div class="col-md-4">
                            <label for="country">Tipo de Operación</label>
                            <select class="custom-select d-block w-100" id="tipoOperacion" name="informacionGeneral[tipoOperacion]" required>
                                <option value="1">Importación</option>
                                <option value="2">Exportación</option>
                            </select>
                            <div class="invalid-feedback">
                                Selecciona un tipo de operación.
                            </div>
                        </div>
                    </div>
                    <hr>
                    <h5 class="mb-3">Información de Ingreso</h5>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="fechaInicioDescarga">Fecha Inicio Descarga</label>
                                <div class="input-group date" id="datetimepicker1" data-target-input="nearest">
                                    <input type="text" class="form-control datetimepicker-input" data-target="#datetimepicker1" name="informacionIngreso[fechaInicioDescarga]" id="fechaInicioDescarga" required/>
                                    <div class="input-group-append" data-target="#datetimepicker1" data-toggle="datetimepicker">
                                        <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                    </div>
                                    <div class="invalid-feedback">
                                        La Fecha Inicio Descarga es requerida.
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="fechaFinDescarga">Fecha Fin Descarga</label>
                                <div class="input-group date" id="datetimepicker2" data-target-input="nearest">
                                    <input type="text" class="form-control datetimepicker-input" data-target="#datetimepicker2" name="informacionIngreso[fechaFinDescarga]" id="fechaFinDescarga" required/>
                                    <div class="input-group-append" data-target="#datetimepicker2" data-toggle="datetimepicker">
                                        <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                    </div>
                                    <div class="invalid-feedback">
                                        La Fecha Fin Descarga es requerida.
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <label for="tipoMercancia">Tipo de Mercancía</label>
                            <select class="custom-select d-block w-100" id="tipoMercancia" name="informacionIngreso[tipoMercancia]" required>
                                <option value="1">3 Días</option>
                                <option value="2">45 Días</option>
                                <option value="3">60 Días</option>
                            </select>
                            <div class="invalid-feedback">
                                Selecciona un tipo de mercancía.
                            </div>
                        </div>
                        <div class="col-md-4">
                            <label for="ingpeso">Peso (Kg)</label>
                            <input type="text" class="form-control" id="ingpeso" name="informacionIngreso[peso]" placeholder="" value="" required>
                            <div class="invalid-feedback">
                                El Peso es requerido.
                            </div>
                        </div>
                        <div class="col-md-4">
                            <label for="condiciones">Condiciones</label>
                            <select class="custom-select d-block w-100" id="condicionCarga" name="informacionIngreso[condicionCarga]" required>
                                <option value="1">Óptimas</option>
                                <option value="2">Carga Mojada</option>
                                <option value="3">Carga Dañada</option>
                            </select>
                            <div class="invalid-feedback">
                                Selecciona las condiciones de la carga.
                            </div>
                        </div>
                    </div>
                    <br>
                    <div class="row">
                        <div class="col-md-12">
                            <label for="observaciones">Observaciones</label>
                            <textarea class="form-control" id="ingobservaciones" name="informacionIngreso[observaciones]" rows="3"></textarea>
                        </div>
                    </div>
                    <hr>
                    <h5 class="mb-3">Información de Transporte</h5>
                    <div class="row">
                        <div class="col-md-5">
                            <label for="lastName">No. de Vuelo</label>
                            <input type="text" class="form-control" id="numeroVueloBuqueViajeImo" name="transporte[numeroVueloBuqueViajeImo]" placeholder="" value="" required>
                            <div class="invalid-feedback">
                                El No. de Vuelo es requerido.
                            </div>
                        </div>
                        <div class="col-md-7">
                            <div class="form-group">
                                <label for="fechaInicioDescarga">Fecha y Hora de Arribo</label>
                                <div class="input-group date" id="datetimepicker3" data-target-input="nearest">
                                    <input type="text" class="form-control datetimepicker-input" data-target="#datetimepicker3" name="transporte[fechaHoraDeArribo]" id="fechaHoraDeArribo" required/>
                                    <div class="input-group-append" data-target="#datetimepicker3" data-toggle="datetimepicker">
                                        <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                    </div>
                                    <div class="invalid-feedback">
                                        La Fecha y Hora de Arribo es requerida.
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-8">
                            <label for="numeroManifiesto">Manifiesto</label>
                            <input type="text" class="form-control" id="numeroManifiesto" name="transporte[numeroManifiesto]" placeholder="" value="" >
                        </div>
                        <div class="col-md-4">
                            <label for="origenVueloBuque">Origen (XYZ)</label>
                            <input type="text" class="form-control" id="origenVueloBuque" name="transporte[origenVueloBuque]" placeholder="" value="" required>
                            <div class="invalid-feedback">
                                El Origen de Vuelo es requerido.
                            </div>
                        </div>
                    </div>
                    <br>
                    <div class="row">
                        <div class="col-md-4">
                            <label for="lastName">CAAT</label>
                            <input type="text" class="form-control" id="caat" name="transporte[caat]" placeholder="" value="" >
                        </div>
                        <div class="col-md-4">
                            <label for="lastName">Peso</label>
                            <input type="text" class="form-control" id="trapeso" name="transporte[peso]" placeholder="" value="" >
                        </div>
                        <div class="col-md-4">
                            <label for="lastName">Piezas</label>
                            <input type="text" class="form-control" id="trapiezas" name="transporte[piezas]" placeholder="" value="" >
                        </div>
                    </div>

                    <hr>
                    <h5 class="mb-3">Guía Master</h5>
                    <div class="row">
                        <div class="col-md-4">
                            <label for="lastName">No. de Guía</label>
                            <input type="text" class="form-control" id="numeroGuiaBl" name="guiaMaster[numeroGuiaBl]" placeholder="" value="" required>
                            <div class="invalid-feedback">
                                El No de Guía Master es requerido.
                            </div>
                        </div>
                        <div class="col-md-4">
                            <label for="lastName">CAAT</label>
                            <input type="text" class="form-control" id="caatm" name="guiaMaster[caat]" placeholder="" value="" >
                        </div>
                        <div class="col-md-4">
                            <label for="country">Tipo de Operación</label>
                            <select class="custom-select d-block w-100" id="tipoOperacionM" name="guiaMaster[tipoOperacion]" required>
                                <option value="1">Importación</option>
                                <option value="2">Exportación</option>
                            </select>
                            <div class="invalid-feedback">
                                Selecciona un tipo de operación.
                            </div>
                        </div>
                    </div>
                    <br>
                    <div class="row">
                        <div class="col-md-4">
                            <label for="peso">Peso</label>
                            <input type="text" class="form-control" id="gmapeso" name="guiaMaster[peso]" placeholder="" value="" >
                        </div>
                        <input type="hidden" class="form-control" id="ump" name="guiaMaster[ump]" placeholder="" value="K" >
                        <div class="col-md-4">
                            <label for="volumen">Volumen</label>
                            <input type="text" class="form-control" id="volumen" name="guiaMaster[volumen]" placeholder="" value="" >
                        </div>
                        <div class="col-md-4">
                            <label for="umv">UMV</label>
                            <input type="text" class="form-control" id="umv" name="guiaMaster[umv]" placeholder="" value="" >
                        </div>
                    </div>
                    <br>
                    <div class="row">
                        <div class="col-md-4">
                            <label for="piezas">Piezas</label>
                            <input type="text" class="form-control" id="gmapiezas" name="guiaMaster[piezas]" placeholder="" value="" >
                        </div>
                        <div class="col-md-4">
                            <label for="country">Tipo de Ingreso</label>
                            <select class="custom-select d-block w-100" id="parcialidad" name="guiaMaster[idParcialidad]" required>
                                <option value="T">Total</option>
                                <option value="P">Parcial</option>
                            </select>
                            <div class="invalid-feedback">
                                Selecciona un tipo de operación.
                            </div>
                        </div>
                        <div class="col-md-4">
                            <label for="secuencia">Secuencia</label>
                            <input type="text" class="form-control" id="gmasecuencia" name="guiaMaster[secuencia]" placeholder="" value="" >                        </div>
                    </div>
                    <br>
                    <div class="row">
                        <div class="col-md-12">
                            <label for="observaciones">Observaciones</label>
                            <textarea class="form-control" id="gmaobservaciones" name="guiaMaster[observaciones]" rows="3"></textarea>
                        </div>
                    </div>
                    <hr>
                    <h5 class="mb-3">Mercancía Guía Master</h5>
                    <div class="row">
                        <div class="col-md-4">
                            <label for="secuencia">Secuencia</label>
                            <input type="text" class="form-control" id="gma_me_secuencia" name="guiaMaster[mercancia][secuencia]" placeholder="" value="" >
                        </div>
                        <div class="col-md-4">
                            <label for="pais">País</label>
                            <input type="text" class="form-control" id="gma_me_pais" name="guiaMaster[mercancia][pais]" placeholder="" value="" >
                        </div>
                        <div class="col-md-4">
                            <label for="pais">Descripción</label>
                            <input type="text" class="form-control" id="gma_me_descripcion" name="guiaMaster[mercancia][descripcion]" placeholder="" value="" >
                        </div>
                    </div>
                    <br>
                    <div class="row">
                        <div class="col-md-4">
                            <label for="secuencia">Peso</label>
                            <input type="text" class="form-control" id="gma_me_peso" name="guiaMaster[mercancia][peso]" placeholder="" value="" >
                        </div>
                        <div class="col-md-4">
                            <label for="pais">UMP</label>
                            <input type="text" class="form-control" id="gma_me_ump" name="guiaMaster[mercancia][ump]" placeholder="" value="" >
                        </div>
                        <div class="col-md-4">
                            <label for="pais">Volumen</label>
                            <input type="text" class="form-control" id="gma_me_volumen" name="guiaMaster[mercancia][volumen]" placeholder="" value="" >
                        </div>
                    </div>
                    <div class="row" id="master_vin" style="margin-top:10px;">
                        <div class="col-md-11">
                            <label for="pais">VIN</label>
                            <input type="text" class="form-control" name="guiaMaster[mercancia][vin][vin]" placeholder="" value="" >
                        </div>
                        <div class="col-md-1">
                            <label>.</label>
                            <button type="button" class="btn btn-primary gma_me_vin_btn"><i class="fa fa-plus-circle" aria-hidden="true"></i></button>
                        </div>
                    </div>
                    <div id="cont_master_vin"></div>
                    <hr class="mb-4">
                    <h5 class="mb-3">Personas Master <button type="button" class="btn btn-primary gma_me_personas_btn" data-pers='0'><i class="fa fa-plus-circle" aria-hidden="true"></i></button></h5>
                    <div class="row" id="master_personas">
                        <div class="col-md-3">
                            <label for="pais">Tipo Persona</label>
                            <input type="text" class="form-control" name="guiaMaster[personas][0][tipoPersona]" placeholder="" value="" >
                        </div>
                        <div class="col-md-9">
                            <label for="pais">Nombre</label>
                            <input type="text" class="form-control" name="guiaMaster[personas][0][nombre]" placeholder="" value="" >
                        </div>
                        <br>
                        <div class="col-md-9">
                            <label for="pais">Calle Domicilio</label>
                            <input type="text" class="form-control"  name="guiaMaster[personas][0][calleDomicilio]" placeholder="" value="" >
                        </div>
                        <div class="col-md-3">
                            <label for="pais">C.P.</label>
                            <input type="text" class="form-control"  name="guiaMaster[personas][0][cp]" placeholder="" value="" >
                        </div>
                        <br>
                        <div class="col-md-6">
                            <label for="pais">Municipio</label>
                            <input type="text" class="form-control" name="guiaMaster[personas][0][municipio]" placeholder="" value="" >
                        </div>
                        <div class="col-md-6">
                            <label for="pais">Entidad Federativa</label>
                            <input type="text" class="form-control"  name="guiaMaster[personas][0][entidadFederativa]" placeholder="" value="" >
                        </div>

                        <div class="col-md-6">
                            <label for="pais">País</label>
                            <input type="text" class="form-control"  name="guiaMaster[personas][0][pais]" placeholder="" value="" >
                        </div>
                        <div class="col-md-6">
                            <label for="rfcOTaxId">RFC o TAXID</label>
                            <input type="text" class="form-control" name="guiaMaster[personas][0][rfcOTaxId]" placeholder="" value="" >
                        </div>
                    </div>
                    <div id="cont_master_personas"></div>
                    <hr class="mb-4">
                    <button class="btn btn-primary btn-lg" type="submit">Enviar Formulario</button>
                </form>
            </div>
        </div>
        <!-- Bootstrap core JavaScript
            ================================================== -->
        <!-- Placed at the end of the document so the pages load faster -->
        <script>window.jQuery || document.write('<script src="https://getbootstrap.com/docs/4.0/assets/js/vendor/jquery-slim.min.js"><\/script>')</script>
        <script src="https://getbootstrap.com/docs/4.0/assets/js/vendor/popper.min.js"></script>
        <script src="https://getbootstrap.com/docs/4.0/dist/js/bootstrap.min.js"></script>
        <script src="https://getbootstrap.com/docs/4.0/assets/js/vendor/holder.min.js"></script>
        <script type="text/javascript">

            $(document).ready(function(){
                $('#datetimepicker1').datetimepicker({
                    format: 'YYYY-MM-DD\THH:mm:ss\Z'
                });
                $('#datetimepicker2').datetimepicker({
                    format: 'YYYY-MM-DD\THH:mm:ss\Z'
                });
                $('#datetimepicker3').datetimepicker({
                    format: 'YYYY-MM-DD\THH:mm:ss\Z'
                });
            });

            $(document).on('click','.gma_me_vin_btn',function(){
                $('#master_vin').clone().appendTo('#cont_master_vin');
            });

            $(document).on('click','.gma_me_personas_btn',function(){
                //determina cuantas personas adicionales se habian solicitado anteriormente
                //es decir, la primera vez el valor sera = 0; y los subsecuentes será X-1;
                var numper = $('#cont_master_personas').find('#master_personas').length;
                var new_numper = numper+1;
                console.log(new_numper);
                //Agrega linea horizontal para separar visualmente las personas
                $('#cont_master_personas').append('<hr class="mb-4">');
                //Clona la persona
                var clonePersona = $('#master_personas').clone();
                clonePersona.html(function(i, oldHTML){
                    //Remplazan los indices para asignar el nuevo correspondiente
                    return oldHTML.replace(/\[0]/g, '['+new_numper+']');
                });
                //Imprime la nueva persona con los indices correctos
                $('#cont_master_personas').append(clonePersona);
            });

        </script>
        <script>
            // Example starter JavaScript for disabling form submissions if there are invalid fields
            (function() {
              'use strict';

              window.addEventListener('load', function() {
                // Fetch all the forms we want to apply custom Bootstrap validation styles to
                var forms = document.getElementsByClassName('needs-validation');

                // Loop over them and prevent submission
                var validation = Array.prototype.filter.call(forms, function(form) {
                  form.addEventListener('submit', function(event) {
                    if (form.checkValidity() === false) {
                      event.preventDefault();
                      event.stopPropagation();
                    }
                    form.classList.add('was-validated');
                  }, false);
                });
              }, false);
            })();
        </script>
    </body>
</html>
