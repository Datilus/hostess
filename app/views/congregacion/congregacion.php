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
        .select2-container--default .select2-selection--single {
            border: 1px solid #ced4da;
            border-radius: 0px;
        }

        .select2-container--default .select2-selection--single .select2-selection__arrow, select.form-control-sm~.select2-container--default .select2-selection--single .select2-selection__arrow {
            top: 3px;
        }

        select.form-control-sm ~ .select2-container--default {
            font-size: .875rem;
        }

        .select2-container .select2-selection--single .select2-selection__rendered {
            padding-left: 0px
        }

        .select2-container--default .select2-results__option {
            padding: 0px 12px;
            font-size: 14px;
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

                        <h4 class="mb-4"><?php echo ( $_SESSION['metodo'] == 'editar' ) ? 'Actualizar' : 'Nueva' ; ?> congregación</h4>

                        <div class="row">
                            <div class="form-group col-md-12">
                                <div class="form-group row mb-0">
                                    <label class="col-sm-3 col-md-2 col-lg-2 col-form-label font-weight-normal text-sm pb-0">Congregación *</label>
                                    <div class="col-sm-8 col-md-6 col-lg-4">
                                        <input type="text" class="form-control form-control-sm rounded-0" id="txt_congregacion" name="txt_congregacion" 
                                        value="<?php echo $datos['datos_congregacion']['congregacion']; ?>"
                                        autocomplete="off">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="form-group col-md-12">
                                <div class="form-group row mb-0">
                                    <label class="col-sm-3 col-md-2 col-lg-2 col-form-label font-weight-normal text-sm pb-0">Calle *</label>
                                    <div class="col-sm-8 col-md-6 col-lg-4">
                                        <input type="text" class="form-control form-control-sm rounded-0" id="txt_calle_salon" name="txt_calle_salon" 
                                        value="<?php echo $datos['datos_congregacion']['calle_salon']; ?>"
                                        autocomplete="off">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="form-group col-md-12">
                                <div class="form-group row mb-0">
                                    <label class="col-sm-3 col-md-2 col-lg-2 col-form-label font-weight-normal text-sm pb-0">Número domicilio</label>
                                    <div class="col-sm-4 col-md-3 col-lg-2">
                                        <input type="text" class="form-control form-control-sm rounded-0" id="txt_numero_domicilio" name="txt_numero_domicilio" 
                                        value="<?php echo $datos['datos_congregacion']['numero_salon']; ?>"
                                        autocomplete="off">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="form-group col-md-12">
                                <div class="form-group row mb-0">
                                    <label class="col-sm-3 col-md-2 col-lg-2 col-form-label font-weight-normal text-sm pb-0">Colonia *</label>
                                    <div class="col-sm-8 col-md-6 col-lg-4">
                                        <select class="form-control form-control-sm rounded-0 select2" id="cmb_colonia" name="cmb_colonia" style="width: 100%;">
                                            <option value=""></option>
                                            <?php
                                            foreach ($datos['colonias'] as $val){
                                                $selected_colonia = (int) ($val["CLAVE"] == $datos['datos_congregacion']['codigo_colonia'] ) ? "selected" : "" ;
                                                echo "<option value='" . $val['CLAVE'] . "' ". $selected_colonia ." >" . mb_strtoupper($val['ASENTAMIENTO']) . "</option>";
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="form-group col-md-12">
                                <div class="form-group row mb-0">
                                    <label class="col-sm-3 col-md-2 col-lg-2 col-form-label font-weight-normal text-sm pb-0">Teléfono *</label>
                                    <div class="col-sm-4 col-md-3 col-lg-2">
                                        <input type="text" class="form-control form-control-sm rounded-0" id="txt_telefono_salon" name="txt_telefono_salon" 
                                        value="<?php echo $datos['datos_congregacion']['telefono_salon']; ?>"
                                        autocomplete="off">
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <input type="hidden" id="txt_id_congregacion" name="txt_id_congregacion" value="<?php echo $datos['datos_congregacion']['id']; ?>">

                        <div class="row mt-4">
                            <div class="form-group col-12">
                                <button type="submit" class="btn btn-primary btn-sm" id="btn_guardar"><?php echo ( $_SESSION['metodo'] == 'editar' ) ? 'Actualizar' : 'Guardar' ; ?> congregación</button>
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

    <!-- REQUIRED SCRIPTS -->
    <?php
    include RUTA_APP . 'views/includes/script-js.php';
    ?>

    <script type="text/javascript">

        $(document).ready(function() {

            $('.select2').select2();
            
        });


        $('#form_congregacion').on('submit', function(e) {
            e.preventDefault();

            $("#btn_guardar").prop('disabled', true);

            $.ajax({
                url: $(this).attr('action'),
                data: $(this).serialize() + "&TOKEN=" + TOKEN,
                type: "POST",
            }).done( function(data) {

                var json_response = JSON.parse(data);

                const opciones = {
                    'success': () => {
                        if ( json_response.error == false ) {

                            UI.create_tab('Consultar congregación', RUTA_URL + CONTROLADOR + '/consultarCongregacion');
                            const message = JSON.stringify({
                                status: json_response.meta_data.status_msg,
                                msg: json_response.message,
                                accion: ACCION
                            });
                            
                            setTimeout(function() {
                                var iframeDestino = window.parent.document.getElementById("consultar-congregacion");
                                iframeDestino.contentWindow.postMessage(message, RUTA_URL + CONTROLADOR + '/consultarCongregacion');

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
            $("#txt_congregacion").val("");
            $("#txt_calle_salon").val("");
            $("#txt_numero_domicilio").val("");
            $("#cmb_colonia").val('').trigger('change');
            $("#txt_telefono_salon").val("");
            $("#txt_id_congregacion").val("");
        }

    </script>

</body>

</html>