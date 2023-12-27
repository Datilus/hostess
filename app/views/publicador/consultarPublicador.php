<?php
// session_start();
?>

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
        let RUTA_URL    = '<?php echo RUTA_URL; ?>';
        let CONTROLADOR = '<?php echo $_SESSION['controlador'];?>';
        let TOKEN       = '<?php echo $_SESSION['token']; ?>';
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
            <div class="content-header pb-2">
                <div class="container-fluid">
                    
                </div><!-- /.container-fluid -->
            </div>
            <!-- /.content-header -->

            <!-- Main content -->
            <div class="content pb-2">
                <div class="container-fluid">
                    <div class="row">
                        <div class="form-group col-12">
                            <button type="button" class="btn btn-default btn-sm" id="btn_nuevo">Añadir nuevo</button>
                            <button type="button" class="btn btn-default btn-sm float-right" id="btn_actualizar"><i class="fa-solid fa-arrows-rotate" style="font-size: 14px;"></i></button>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12">
                            <input type="search" class="form-control rounded-0" id="searchbox" placeholder="Buscar">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12 table-responsive">
                            <!-- <table id="gridPublicador" class="table table-bordered table-striped dataTable dtr-inline" role="grid" style="font-size: 12px;"> -->
                            <table id="gridPublicador" class="table table-hover" role="grid" style="font-size: 12px; width: 100%; margin-top: 0px !important;">
                                <thead>
                                    <tr>
                                        <th>#Id</th>
                                        <th>Publicador</th>
                                        <th>Domicilio</th>
                                        <th>Contácto</th>
                                        <th>Tipo</th>
                                        <th>Grupo</th>
                                        <th>Estatus</th>
                                        <th></th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                        
                    </div>
                    <!-- /.row -->
                </div>
                <!-- /.container-fluid -->
            </div>
            <!-- /.content -->
        </div>
        <!-- /.content-wrapper -->

        <?php 
        //include RUTA_APP . 'views/includes/control_sidebar_right.php';
        //include RUTA_APP . 'views/includes/footer.php';
        ?>
    </div>
    <!-- ./wrapper -->

    <!-- Modales -->
    <div class="modal fade" id="modal_info" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content shadow-none">
                <div class="modal-header">
                    <h5 class="modal-title" id="myModalLabel"><span id="lbl_nombre_publicador"></span></h5>
                </div>
                <div class="modal-body">
                    
                    <div class="col-lg-12">
                        <div class="row invoice-info" style="font-size: 12px;">
                            <div class="col-sm-12 invoice-col">
                                <b>Batismo: </b><span id="lbl_bautismo"></span><br>
                                <b>Nombre: </b><span id="lbl_nombre"></span><br>
                                <b>Nacimiento: </b><span id="lbl_nacimiento"></span><br>
                                <b>Domicilio: </b><span id="lbl_domicilio"></span><br>
                                <b>Teléfono: </b><span id="lbl_telefono"></span><br>
                                <b>Celular: </b><span id="lbl_celular"></span><br>
                                <b>Grupo: </b><span id="lbl_grupo"></span><br>
                            </div>

                        </div>
                    </div>

                    <div class="col-lg-12">
                        <h6 class="mt-3 mb-0">Contactos de emergencia <span id="lbl_iNumHabitaciones"></span></h6>
                        <div class="row table-responsive">
                            <table id="gridContactos" class="table table-striped table-sm" style="font-size: 11px; width: 100%;">
                                <thead>
                                    <tr>
                                        <th>Nombre</th>
                                        <th>Domicilio</th>
                                        <th>Contácto</th>
                                        <th>Parentesco</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    </div>

                </div>

                <div class="card-footer">
                    <div class="btn btn-secondary float-right" data-dismiss="modal">Cerrar</div>
                </div>
            </div>
        </div>
    </div>


    <!-- REQUIRED SCRIPTS -->
    <?php 
    include RUTA_APP . 'views/includes/script-js.php';
    ?>
    
    <script type="text/javascript">

        $(document).ready(function () {

            window.addEventListener('message', function(event) {

                var data = JSON.parse(event.data);

                const option = {
                    'success': (data) => {

                        toastr.success(data.msg);
                        tablePublicador.clear().draw();
                        tablePublicador.state.save();

                        // Cerramos el tab editar
                        if ( data.accion == 'editar' ){
                            
                            // Acceder al iframe hijo por su nombre o ID
                            let iframeHijo = window.parent.document.getElementById('editar-publicador');
                            iframeHijo.parentNode.remove(iframeHijo);

                            let url = iframeHijo.src.slice(0, -2);
                            url = Utilerias.convertirURLaID(url);

                            var iframeDestino = window.parent.document.getElementById("tab-" + url);
                            iframeDestino.parentNode.remove(iframeDestino);
                        }
                    }
                };

                const opcion = option[data.status] ? option[data.status](data) : '' ;
            });
            

            // --- INICIALIZAMOS DATATABLES
            const tablePublicadorParam = {
                length: 15,
                url: RUTA_URL + CONTROLADOR + "/data_table_list",
                data: {
                    "TOKEN": TOKEN
                },
                columns: [
                    {"width": "6%","className": "text-center","targets": [7]}
                ]
            };
            tablePublicador = $('#gridPublicador').DataTable(
                UI.paramsDataTable( 
                    tablePublicadorParam.length, 
                    tablePublicadorParam.url, 
                    tablePublicadorParam.data, 
                    tablePublicadorParam.columns
                )
            );
            tablePublicador_filter = $('#gridPublicador').dataTable();
            $("#searchbox").keyup(function() {
                tablePublicador_filter.fnFilter(this.value);
            });


            tableContactos = $('#gridContactos').DataTable({
                "responsive": false,
                "searching": false,
                "paging": false,
                "lengthMenu": [
                    [-1],
                    ["All"]
                ],
                "ordering": false,
                "info": false,
                "bJQueryUI": true,
                "columnDefs": [],
                "oLanguage": UI.SpanishDataTable()
            });

        });

        document.getElementById('btn_nuevo').addEventListener('click', function(e) {
            UI.create_tab('Nuevo publicador', RUTA_URL + 'publicador');
        });

        document.getElementById('btn_actualizar').addEventListener('click', function(e) {
            location.href = RUTA_URL + CONTROLADOR + '/consultarPublicador';
        });


        // --- Opciones
        const opciones = {
            'info': (id_publicador) => {
                mostrar_info(id_publicador);
            },
            'editar': (id_publicador) => {

                setTimeout(function() {
                    // UI.create_tab('Editar publicador', RUTA_URL + 'publicador/editar');
                    UI.create_tab('Editar publicador', '' );
                    let iframeDestino = window.parent.document.getElementById("editar-publicador");
                    let url = RUTA_URL + CONTROLADOR + '/editar/' + id_publicador;
                    iframeDestino.src = url;
                }, 500);

            },
            'borrar': (id_publicador) => {
                
                bootbox.confirm({
                    message: "Estás seguro de borrar este registro?",
                    buttons: {
                        confirm: {
                            label: 'Si'
                        },
                        cancel: {
                            label: 'No'
                        }
                    },
                    callback: function (result) {
                        if (result == true) {
                            
                            $.ajax({
                                url: RUTA_URL + CONTROLADOR + '/borrar',
                                data: {
                                    "id_publicador": id_publicador,
                                    "TOKEN": TOKEN
                                },
                                type: "POST",
                            }).done( function(data) {

                                var json_response = JSON.parse(data);

                                const opciones = {
                                    'success': () => {

                                        if ( json_response.error == false ){
                                            toastr.success(json_response.message)

                                            tablePublicador.clear().draw();
                                            tablePublicador.state.save();
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
                                
                            });
                        }
                    }
                });
            },
        };
        document.getElementById('gridPublicador').addEventListener('click', function(e) {
            let id_publicador = e.target.getAttribute('data-id_publicador') ? e.target.getAttribute('data-id_publicador') : '';
            const opcion = opciones[e.target.name] ? opciones[e.target.name](id_publicador) : '';
        });



        let modal_info = new bootstrap.Modal(document.getElementById("modal_info"), {
            backdrop: 'static',
            keyboard: false
        });

        function mostrar_info(id_publicador)
        {
            $.ajax({
                url: RUTA_URL + CONTROLADOR + '/info_publicador',
                type: "POST",
                data: {
                    id_publicador: id_publicador,
                    TOKEN: TOKEN
                },
                success: function(datos) {

                    var myJson = JSON.parse(datos);

                    const opciones = {
                        'success': () => {

                            modal_info.show();

                            setTimeout(function() {

                                $("#lbl_nombre_publicador").html(myJson.arrayDatos.nombre + ' ' + myJson.arrayDatos.apellido_paterno + ' ' + myJson.arrayDatos.apellido_materno);
                                $("#lbl_bautismo").html(myJson.arrayDatos.fecha_bautismo + ', Tiempo: ' + myJson.arrayDatos.tiempo_bautizado + ' años');
                                $("#lbl_nombre").html(myJson.arrayDatos.nombre + ' ' + myJson.arrayDatos.apellido_paterno + ' ' + myJson.arrayDatos.apellido_materno);
                                $("#lbl_nacimiento").html(myJson.arrayDatos.fecha_nacimiento + ', Edad: ' + myJson.arrayDatos.edad + ' años');
                                $("#lbl_domicilio").html(myJson.arrayDatos.calle_casa + ' ' + myJson.arrayDatos.numero_casa + ' ' + myJson.arrayDatos.colonia);
                                $("#lbl_telefono").html(myJson.arrayDatos.telefono);
                                $("#lbl_celular").html(myJson.arrayDatos.movil);
                                $("#lbl_grupo").html(myJson.arrayDatos.grupo);

                                let json_contactos = JSON.parse(myJson.arrayDatos.json_contactos);

                                // Requerimientos
                                tableContactos.clear().draw();
                                if (json_contactos.length > 0) {
                                    $(json_contactos).each(function(key, val) {
                                        tableContactos.row.add([
                                            val.nombre,
                                            val.direccion,
                                            val.numero,
                                            val.parentesco
                                        ]).draw();
                                    })
                                } else {
                                    tableContactos = $('#gridContactos').DataTable();
                                }

                            }, 1000);
                        }
                    };
                    const opcion_default = () => {
                        toastr.error("Se ha producido un error");
                    };
                    const estatus = opciones[myJson.status] ? opciones[myJson.status]() : opcion_default();
                }
            });
            
        }

    </script>
</body>
</html>
