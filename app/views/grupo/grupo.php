<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title><?php echo NOMBRE_SISTEMA; ?> | <?php echo $datos['titulo_controlador']; ?></title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- REQUIRED SCRIPTS -->
    <?php
    include RUTA_APP . 'views/includes/script-css.php';
    ?>

    <style type="text/css">
        .dataTables_filter {
            display: none;
        }

        .dataTables_length {
            display: none;
        }

        .badge {
            font-size: 11px;
            border-radius: 9px;
            font-weight: 400;
            padding: 0.25em 0.6em;
        }

        .floating-menu {
            font-family: sans-serif;
            background: yellowgreen;
            padding: 5px;
            width: fit-content;
            right: 15px;
            top: 23px;
            z-index: 1050;
            position: fixed;

            border: 1px solid rgba(0, 0, 0, .125);
            border-radius: 0.25rem;
        }

        .floating-menu a,
        .floating-menu h3 {
            font-size: 0.9em;
            display: block;
            /*margin: 0 0.5em;*/
            color: white;
        }
    </style>

    <script type="text/javascript">
        var RUTA_URL = '<?php echo RUTA_URL; ?>';
        var CONTROLADOR = '<?php echo $_SESSION['controlador']; ?>';
        var ACCION = '<?php echo $_SESSION['metodo']; ?>';
        var TOKEN = '<?php echo $_SESSION['token']; ?>';
    </script>

</head>

<body class="hold-transition layout-fixed sidebar-collapse">
    <div class="wrapper">

        <?php
        //include RUTA_APP . 'views/includes/header.php';
        //include RUTA_APP . 'views/includes/left_sidebar_menu.php'; 
        ?>

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper" style="height: auto;">
            <!-- Content Header (Page header) -->
            <div class="content-header">
                <div class="container-fluid">

                </div><!-- /.container-fluid -->
            </div>
            <!-- /.content-header -->

            <!-- Main content -->
            <div class="content">
                <div class="container-fluid">

                    <form id="form_<?php echo $_SESSION["controlador"]; ?>" action="<?php echo RUTA_URL . $_SESSION["controlador"]; ?>/guardar" method="post">

                        <h4 class="mb-4"><?php echo ( $_SESSION['metodo'] == 'editar' ) ? 'Actualizar' : 'Nuevo' ; ?> grupo</h4>

                        <div class="row">
                            <div class="form-group col-md-12">
                                <div class="form-group row mb-0">
                                    <label class="col-sm-3 col-md-2 col-lg-2 col-form-label font-weight-normal text-sm pb-0">Nombre grupo *</label>
                                    <div class="col-sm-8 col-md-6 col-lg-4">
                                        <input type="text" class="form-control form-control-sm rounded-0" id="txt_grupo" name="txt_grupo" 
                                        value="<?php echo $datos['datos_grupo']['nombre_grupo']; ?>"
                                        autocomplete="off">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="form-group col-md-12 mb-1">
                                <div class="form-group row mb-0">
                                    <label class="col-sm-3 col-md-2 col-lg-2 col-form-label font-weight-normal text-sm pb-0">Responsable *</label>
                                    <div class="col-sm-8 col-md-6 col-lg-4">
                                        <div class="btn btn-default btn-sm" id="btn_catalogo_publicador_responsable">Añadir responsable</div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="form-group col-md-12">
                                <div class="form-group row mb-0">
                                    <label class="col-sm-3 col-md-2 col-lg-2 col-form-label font-weight-normal text-sm pb-0"></label>
                                    <div class="col-sm-8 col-md-6 col-lg-4">
                                        <input type="text" class="form-control form-control-sm form-control-plaintext rounded-0" id="txt_responsable" name="txt_responsable"
                                        value="<?php echo $datos['datos_grupo']['responsable']; ?>"
                                        placeholder="Nombre del publicador responsable..."
                                        autocomplete="off"
                                        readonly>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <input type="hidden" id="txt_id_responsable" name="txt_id_responsable" value="<?php echo $datos['datos_grupo']['id_responsable']; ?>">

                        <div class="row">
                            <div class="form-group col-md-12 mb-1">
                                <div class="form-group row mb-0">
                                    <label class="col-sm-3 col-md-2 col-lg-2 col-form-label font-weight-normal text-sm pb-0">Auxiliar *</label>
                                    <div class="col-sm-8 col-md-6 col-lg-4">
                                        <div class="btn btn-default btn-sm" id="btn_catalogo_publicador_auxiliar">Añadir auxiliar</div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="form-group col-md-12">
                                <div class="form-group row mb-0">
                                    <label class="col-sm-3 col-md-2 col-lg-2 col-form-label font-weight-normal text-sm pb-0"></label>
                                    <div class="col-sm-8 col-md-6 col-lg-4">
                                        <input type="text" class="form-control form-control-sm form-control-plaintext rounded-0" id="txt_auxiliar" name="txt_auxiliar"
                                        value="<?php echo $datos['datos_grupo']['auxiliar']; ?>"
                                        placeholder="Nombre del publicador auxiliar..."
                                        autocomplete="off"
                                        readonly>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <input type="hidden" id="txt_id_auxiliar" name="txt_id_auxiliar" value="<?php echo $datos['datos_grupo']['id_auxiliar']; ?>">
                        
                        <input type="hidden" id="txt_id_grupo" name="txt_id_grupo" value="<?php echo $datos['datos_grupo']['id']; ?>">

                        <div class="row mt-4">
                            <div class="form-group col-12">
                                <button type="submit" class="btn btn-primary btn-sm" id="btn_guardar"><?php echo ( $_SESSION['metodo'] == 'editar' ) ? 'Actualizar' : 'Guardar' ; ?> grupo</button>
                            </div>
                        </div>

                    </form>
                </div>
            </div>
        </div>

        <?php
        //include RUTA_APP . 'views/includes/control_sidebar_right.php';
        //include RUTA_APP . 'views/includes/footer.php';
        ?>
    </div>

    <!-- Modales -->
    <div class="modal fade" id="modal_responsable" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content shadow-none">
                <div class="modal-header">
                    <h5 class="modal-title" id="myModalLabel">Publicadores</h5>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-lg-12">
                            <input type="search" class="form-control rounded-0" id="searchbox_responsable" placeholder="Buscar">
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-md-12 table-responsive mb-0">
                            <table id="gridResponsable" class="table table-bordered table-striped dataTable dtr-inline" style="font-size: 11px; width: 100%; margin-top: 0px !important;">
                                <thead>
                                    <tr>
                                        <th>id_responsable</th>
                                        <th>Publicador</th>
                                        <th></th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <div class="btn btn-secondary" data-dismiss="modal">Cerrar</div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modal_auxiliar" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content shadow-none">
                <div class="modal-header">
                    <h5 class="modal-title" id="myModalLabel">Publicadores</h5>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-lg-12">
                            <input type="search" class="form-control rounded-0" id="searchbox_auxiliar" placeholder="Buscar">
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-md-12 table-responsive mb-0">
                            <table id="gridAuxiliar" class="table table-bordered table-striped dataTable dtr-inline" style="font-size: 11px; width: 100%; margin-top: 0px !important;">
                                <thead>
                                    <tr>
                                        <th>id_auxiliar</th>
                                        <th>Publicador</th>
                                        <th></th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <div class="btn btn-secondary" data-dismiss="modal">Cerrar</div>
                </div>
            </div>
        </div>
    </div>

    <!-- REQUIRED SCRIPTS -->
    <?php
    include RUTA_APP . 'views/includes/script-js.php';
    ?>

    <script type="text/javascript">

        $(document).ready(function() {

        });

        let modal_responsable = new bootstrap.Modal(document.getElementById("modal_responsable"), {
            backdrop: 'static',
            keyboard: false
        });

        $('#btn_catalogo_publicador_responsable').on('click', function(){
            inicializarResponsable();
            modal_responsable.show();
            setTimeout(function() {
                $('#searchbox_responsable').focus();
            }, 500);
        });

        function inicializarResponsable() 
        {
            $('#gridResponsable').DataTable().destroy();

            const tablePublicadorParam = {
                length: 15,
                url: RUTA_URL + "publicador/data_table_list_catalogo",
                data: {
                    "TOKEN": TOKEN
                },
                columns: [
                    {"width": "8%", "className": "text-center", "targets": 2},
                    {"width": "5%", "visible": false, "targets": [0]}
                ]
            };
            tablaPublicador = $('#gridResponsable').DataTable(
                UI.paramsDataTable(tablePublicadorParam.length, tablePublicadorParam.url, tablePublicadorParam.data, tablePublicadorParam.columns)
            );
            tablaPublicador_filter = $('#gridResponsable').dataTable();
            $("#searchbox_responsable").keyup(function() {
                tablaPublicador_filter.fnFilter(this.value);
            });
        }

        $('#gridResponsable').on("click", "i", function() {
            let rowData;

            // Obtenemos todos los valores contenidos en los <td> de la fila seleccionada
            $(this).parents("tr").find("td").each(function() {
                rowData = tablaPublicador.row(this).data();
            });

            $("#txt_responsable").val(rowData[1]);
            $("#txt_id_responsable").val(rowData[0]);

            modal_responsable.hide();

        });


        let modal_auxiliar = new bootstrap.Modal(document.getElementById("modal_auxiliar"), {
            backdrop: 'static',
            keyboard: false
        });

        $('#btn_catalogo_publicador_auxiliar').on('click', function(){
            inicializarAuxiliar();
            modal_auxiliar.show();
            setTimeout(function() {
                $('#searchbox_auxiliar').focus();
            }, 500);
        });

        function inicializarAuxiliar() 
        {
            $('#gridAuxiliar').DataTable().destroy();

            const tablePublicadorParam = {
                length: 15,
                url: RUTA_URL + "publicador/data_table_list_catalogo",
                data: {
                    "TOKEN": TOKEN
                },
                columns: [
                    {"width": "8%", "className": "text-center", "targets": 2},
                    {"width": "5%", "visible": false, "targets": [0]}
                ]
            };
            tablaPublicador = $('#gridAuxiliar').DataTable(
                UI.paramsDataTable(tablePublicadorParam.length, tablePublicadorParam.url, tablePublicadorParam.data, tablePublicadorParam.columns)
            );
            tablaPublicador_filter = $('#gridAuxiliar').dataTable();
            $("#searchbox_auxiliar").keyup(function() {
                tablaPublicador_filter.fnFilter(this.value);
            });
        }

        $('#gridAuxiliar').on("click", "i", function() {
            let rowData;

            // Obtenemos todos los valores contenidos en los <td> de la fila seleccionada
            $(this).parents("tr").find("td").each(function() {
                rowData = tablaPublicador.row(this).data();
            });

            $("#txt_auxiliar").val(rowData[1]);
            $("#txt_id_auxiliar").val(rowData[0]);

            modal_auxiliar.hide();

        });


        $('#form_grupo').on('submit', function(e) {
            e.preventDefault();

            // $("#btn_guardar").prop('disabled', true);

            $.ajax({
                url: $(this).attr('action'),
                data: $(this).serialize() + "&TOKEN=" + TOKEN,
                type: "POST",
            }).done( function(data) {

                var json_response = JSON.parse(data);

                const opciones = {
                    'success': () => {
                        if ( json_response.error == false ) {

                            UI.create_tab('Consultar grupo', RUTA_URL + CONTROLADOR + '/consultarGrupo');
                            const message = JSON.stringify({
                                status: json_response.meta_data.status_msg,
                                msg: json_response.message,
                                accion: ACCION
                            });
                            
                            setTimeout(function() {
                                var iframeDestino = window.parent.document.getElementById("consultar-grupo");
                                iframeDestino.contentWindow.postMessage(message, RUTA_URL + CONTROLADOR + '/consultarGrupo');

                                if ( ACCION != 'editar' ) {
                                    setTimeout(function() {
                                        reset_form();
                                    }, 500);
                                }

                            }, 1000);

                            /* setTimeout(function() {
                                toastr.success(json_response.message);
                                reset_form();
                            }, 500); */
                        }
                    },
                    'warning': () => {
                        toastr.warning(json_response.message);
                    },
                    'error': () => {
                        toastr.error(json_response.message);
                    }
                }
                const opcion_default = () => {
                    toastr.error("Se ha producido un error");
                };
                
                const estatus = opciones[json_response.meta_data.status_msg] ? opciones[json_response.meta_data.status_msg]() : opcion_default();

            }).always( function() {
                setTimeout(function() {
                    $("#btn_guardar").prop('disabled', false);
                }, 300);
            });

        });

        function reset_form() 
        {
            $("#txt_grupo").val("");
            $("#txt_responsable").val("");
            $("#txt_id_responsable").val("");
            $("#txt_auxiliar").val("");
            $("#txt_id_auxiliar").val("");
            $("#txt_id_grupo").val("");
        }

    </script>

</body>

</html>