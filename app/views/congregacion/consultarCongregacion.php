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
                            <button type="button" class="btn btn-default btn-sm" id="btn_nuevo">Añadir nueva</button>
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
                            <!-- <table id="gridCongregacion" class="table table-bordered table-striped dataTable dtr-inline" role="grid" style="font-size: 12px;"> -->
                            <table id="gridCongregacion" class="table table-hover" role="grid" style="font-size: 12px; width: 100%; margin-top: 0px !important;">
                                <thead>
                                    <tr>
                                        <th>#Id</th>
                                        <th>Congregación</th>
                                        <th>Dirección</th>
                                        <th>Teléfono</th>
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
                    tableCongregacion.clear().draw();
                    tableCongregacion.state.save();

                    // Cerramos el tab editar
                    if ( data.accion == 'editar' ){
                        
                        // Acceder al iframe hijo por su nombre o ID
                        let iframeHijo = window.parent.document.getElementById('editar-congregacion');
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
            const tableCongregacionParam = {
                length: 15,
                url: RUTA_URL + CONTROLADOR + "/data_table_list",
                data: {
                    "TOKEN": TOKEN
                },
                columns: [
                    {"width": "6%","className": "text-center","targets": [4]}
                ]
            };
            tableCongregacion = $('#gridCongregacion').DataTable(
                UI.paramsDataTable( 
                    tableCongregacionParam.length, 
                    tableCongregacionParam.url, 
                    tableCongregacionParam.data, 
                    tableCongregacionParam.columns
                )
            );
            tableCongregacion_filter = $('#gridCongregacion').dataTable();
            $("#searchbox").keyup(function() {
                tableCongregacion_filter.fnFilter(this.value);
            });

        });

        document.getElementById('btn_nuevo').addEventListener('click', function(e) {
            UI.create_tab('Nueva congregación', RUTA_URL + 'congregacion');
        });

        document.getElementById('btn_actualizar').addEventListener('click', function(e) {
            location.href = RUTA_URL + CONTROLADOR + '/consultarCongregacion';
        });


        // --- Opciones
        const opciones = {
            'editar': (id_congregacion) => {

                setTimeout(function() {
                    UI.create_tab('Editar Congregación', RUTA_URL + 'congregacion/editar');
                    let iframeDestino = window.parent.document.getElementById("editar-congregacion");
                    let url = RUTA_URL + CONTROLADOR + '/editar/' + id_congregacion;
                    iframeDestino.src = url;
                }, 500);

            },
            'borrar': (id_congregacion) => {

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
                                    "id_congregacion": id_congregacion,
                                    "TOKEN": TOKEN
                                },
                                type: "POST",
                            }).done( function(data) {

                                var json_response = JSON.parse(data);

                                const opciones = {
                                    'success': () => {

                                        if ( json_response.error == false ){
                                            toastr.success(json_response.message)

                                            tableCongregacion.clear().draw();
                                            tableCongregacion.state.save();
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
        document.getElementById('gridCongregacion').addEventListener('click', function(e) {
            let id_congregacion = e.target.getAttribute('data-id_congregacion') ? e.target.getAttribute('data-id_congregacion') : '';
            const opcion = opciones[e.target.name] ? opciones[e.target.name](id_congregacion) : '';
        });

    </script>
</body>
</html>
