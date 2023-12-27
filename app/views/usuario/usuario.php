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

                        <h4 class="mb-4"><?php echo ( $_SESSION['metodo'] == 'editar' ) ? 'Actualizar' : 'Nuevo' ; ?> usuario</h4>

                        <div class="row">
                            <div class="form-group col-md-12">
                                <div class="form-group row mb-0">
                                    <label class="col-sm-3 col-md-2 col-lg-2 col-form-label font-weight-normal text-sm pb-0">Perfil *</label>
                                    <div class="col-sm-4 col-md-3 col-lg-2">
                                        <select class="form-control form-control-sm rounded-0" id="cmb_perfil" name="cmb_perfil" style="width: 100%;">
                                            <option value="0">Seleccionar perfil</option>
                                            <?php
                                            foreach ($datos['perfil'] as $val){
                                                $selected_perfil = ($val['ID_PERFIL'] == $datos['datos_usuario']['id_perfil'] ) ? "selected" : "" ;
                                                echo "<option value='" . $val['ID_PERFIL'] . "' ". $selected_perfil ." >" . mb_strtoupper($val['PERFIL']) . "</option>";
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="form-group col-md-12 mb-1">
                                <div class="form-group row mb-0">
                                    <label class="col-sm-3 col-md-2 col-lg-2 col-form-label font-weight-normal text-sm pb-0">Publicador *</label>
                                    <div class="col-sm-8 col-md-6 col-lg-4">
                                        <div class="btn btn-default btn-sm" id="btn_catalogo_publicador">Añadir publicador</div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="form-group col-md-12">
                                <div class="form-group row mb-0">
                                    <label class="col-sm-3 col-md-2 col-lg-2 col-form-label font-weight-normal text-sm pb-0"></label>
                                    <div class="col-sm-8 col-md-6 col-lg-4">
                                        <input type="text" class="form-control form-control-sm form-control-plaintext rounded-0" id="txt_publicador" name="txt_publicador"
                                        value="<?php echo $datos['datos_usuario']['publicador']; ?>"
                                        placeholder="Nombre del publicador..."
                                        autocomplete="off">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <input type="hidden" id="txt_id_publicador" name="txt_id_publicador" value="<?php echo $datos['datos_usuario']['id_publicador']; ?>">
                        <input type="hidden" name="accion" value="<?php echo $accion; ?>">

                        <div class="row">
                            <div class="form-group col-md-12">
                                <div class="form-group row mb-0">
                                    <label class="col-sm-3 col-md-2 col-lg-2 col-form-label font-weight-normal text-sm pb-0">Usuario *</label>
                                    <div class="col-sm-8 col-md-6 col-lg-4">
                                        <input type="text" class="form-control form-control-sm rounded-0" id="txt_usuario" name="txt_usuario" 
                                        value="<?php echo $datos['datos_usuario']['usuario']; ?>"
                                        autocomplete="off">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="form-group col-md-12">
                                <div class="form-group row mb-0">
                                    <label class="col-sm-3 col-md-2 col-lg-2 col-form-label font-weight-normal text-sm pb-0">Password *</label>
                                    <div class="col-sm-8 col-md-6 col-lg-4">
                                        <input type="password" class="form-control form-control-sm rounded-0" id="txt_password" name="txt_password" 
                                        value="<?php echo $datos['datos_usuario']['password']; ?>"
                                        autocomplete="off">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <input type="hidden" id="txt_id_usuario" name="txt_id_usuario" value="<?php echo $datos['datos_usuario']['id_usuario']; ?>">

                        <div class="row mt-4">
                            <div class="form-group col-12">
                                <button type="submit" class="btn btn-primary btn-sm" id="btn_guardar"><?php echo ( $_SESSION['metodo'] == 'editar' ) ? 'Actualizar' : 'Guardar' ; ?> usuario</button>
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
    <div class="modal fade" id="modal_publicador" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content shadow-none">
                <div class="modal-header">
                    <h5 class="modal-title" id="myModalLabel">Publicadores</h5>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-lg-12">
                            <input type="search" class="form-control rounded-0" id="searchbox_publicador" placeholder="Buscar">
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-md-12 table-responsive mb-0">
                            <table id="gridPublicador" class="table table-bordered table-striped dataTable dtr-inline" style="font-size: 11px; width: 100%; margin-top: 0px !important;">
                                <thead>
                                    <tr>
                                        <th>id_publicador</th>
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

            $('.select2').select2();
            
        });


        let modal_publicador = new bootstrap.Modal(document.getElementById("modal_publicador"), {
            backdrop: 'static',
            keyboard: false
        });

        $('#btn_catalogo_publicador').on('click', function(){
            inicializarPublicadores();
            modal_publicador.show();
            setTimeout(function() {
                $('#searchbox_publicador').focus();
            }, 500);
        });

        function inicializarPublicadores() 
        {
            $('#gridPublicador').DataTable().destroy();

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
            tablaPublicador = $('#gridPublicador').DataTable(
                UI.paramsDataTable(tablePublicadorParam.length, tablePublicadorParam.url, tablePublicadorParam.data, tablePublicadorParam.columns)
            );
            tablaPublicador_filter = $('#gridPublicador').dataTable();
            $("#searchbox_publicador").keyup(function() {
                tablaPublicador_filter.fnFilter(this.value);
            });
        }

        $('#gridPublicador').on("click", "i", function() {
            let rowData;

            // Obtenemos todos los valores contenidos en los <td> de la fila seleccionada
            $(this).parents("tr").find("td").each(function() {
                rowData = tablaPublicador.row(this).data();
            });

            $("#txt_publicador").val(rowData[1]);
            $("#txt_id_publicador").val(rowData[0]);

            modal_publicador.hide();

        });


        $('#form_usuario').on('submit', function(e) {
            e.preventDefault();

            // $("#btn_guardar").prop('disabled', true);

            $.ajax({
                url: $(this).attr('action'),
                data: $(this).serialize() + "&ACCION=" + ACCION + "&TOKEN=" + TOKEN,
                type: "POST",
            }).done( function(data) {

                var json_response = JSON.parse(data);

                console.log(json_response);

                const opciones = {
                    'success': () => {
                        if ( json_response.error == false ) {

                            UI.create_tab('Consultar usuario', RUTA_URL + CONTROLADOR + '/consultarUsuario');
                            const message = JSON.stringify({
                                status: json_response.meta_data.status_msg,
                                msg: json_response.message,
                                accion: ACCION
                            });
                            
                            setTimeout(function() {
                                var iframeDestino = window.parent.document.getElementById("consultar-usuario");
                                iframeDestino.contentWindow.postMessage(message, RUTA_URL + CONTROLADOR + '/consultarUsuario');

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
            document.getElementById("cmb_perfil").selectedIndex = "0";
            $("#txt_publicador").val("");
            $("#txt_id_publicador").val("");
            $("#txt_usuario").val("");
            $("#txt_password").val("");
            $("#txt_id_usuario").val("");
        }

    </script>

</body>

</html>