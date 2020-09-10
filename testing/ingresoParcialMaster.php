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
            <h2>IngresoParcialMaster</h2>
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
                <h4 class="mb-3">Información de Ingreso</h4>
                <form class="needs-validation" novalidate action="../IngresoParcial/Master" method="get" enctype="multipart/form-data">
                    <div class="row">
                        <div class="col-md-4">
                            <label for="firstName">Consecutivo</label>
                            <input type="text" class="form-control" id="consecutivo" name="consecutivo" placeholder="" value="" required>
                            <div class="invalid-feedback">
                                El consecutivo es requerido.
                            </div>
                        </div>
                        <div class="col-md-4">
                            <label for="lastName">idAsociado</label>
                            <input type="text" class="form-control" id="idAsociado" name="idAsociado" placeholder="" value="" required>
                            <div class="invalid-feedback">
                                El idAsociado es requerido.
                            </div>
                        </div>
                        <div class="col-md-4">
                            <label for="country">Tipo de Operación</label>
                            <select class="custom-select d-block w-100" id="tipoOperacion" name="tipoOperacion" required>
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
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="fechaInicioDescarga">Fecha Inicio Descarga</label>
                                <div class="input-group date" id="datetimepicker1" data-target-input="nearest">
                                    <input type="text" class="form-control datetimepicker-input" data-target="#datetimepicker1" name="fechaInicioDescarga" id="fechaInicioDescarga" required/>
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
                                    <input type="text" class="form-control datetimepicker-input" data-target="#datetimepicker2" name="fechaFinDescarga" id="fechaFinDescarga" required/>
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
                    <br>
                    <div class="row">
                        <div class="col-md-4">
                            <label for="country">Tipo de Mercancía</label>
                            <select class="custom-select d-block w-100" id="tipoMercancia" name="tipoMercancia" required>
                                <option value="1">3 Días</option>
                                <option value="2">45 Días</option>
                                <option value="3">60 Días</option>
                            </select>
                            <div class="invalid-feedback">
                                Selecciona un tipo de mercancía.
                            </div>
                        </div>
                        <div class="col-md-4">
                            <label for="lastName">Peso (Kg)</label>
                            <input type="text" class="form-control" id="peso" name="peso" placeholder="" value="" required>
                            <div class="invalid-feedback">
                                El Peso es requerido.
                            </div>
                        </div>
                        <div class="col-md-4">
                            <label for="lastName">Piezas</label>
                            <input type="text" class="form-control" id="piezas" name="piezas" placeholder="" value="" required>
                            <div class="invalid-feedback">
                                El Número de Piezas es requerido.
                            </div>
                        </div>
                    </div>
                    <br>
                    <div class="row">
                        <div class="col-md-4">
                            <label for="lastName">No. Parcialidad</label>
                            <input type="text" class="form-control" id="numeroParcialidad" name="numeroParcialidad" placeholder="" value="" required>
                            <div class="invalid-feedback">
                                El Número de Parcialidad es requerido.
                            </div>
                        </div>
                        <div class="col-md-4">
                            <label for="country">Condiciones</label>
                            <select class="custom-select d-block w-100" id="condicionCarga" name="condicionCarga" required>
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
                            <textarea class="form-control" id="observaciones" name="observaciones" rows="5"></textarea>
                        </div>
                    </div>
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
