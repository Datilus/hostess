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

                        <h5 class="mb-4"><?php echo ( $_SESSION['metodo'] == 'editar' ) ? 'Actualizar' : 'Nuevo' ; ?> perfil</h5>

                        <div class="row">
                            <div class="form-group col-md-12">
                                <div class="form-group row mb-0">
                                    <label class="col-sm-3 col-md-2 col-lg-2 col-form-label font-weight-normal text-sm pb-0">Perfil *</label>
                                    <div class="col-sm-8 col-md-6 col-lg-4">
                                        <input type="text" class="form-control form-control-sm rounded-0" id="txt_perfil" name="txt_perfil" 
                                        value="<?php echo $datos['datos_perfil']['perfil']; ?>"
                                        autocomplete="off">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="form-group col-md-12">
                                <div class="form-group row mb-0">
                                    <label class="col-sm-3 col-md-2 col-lg-2 col-form-label font-weight-normal text-sm pb-0">Descipción </label>
                                    <div class="col-sm-8 col-md-6 col-lg-4">
                                        <textarea class="form-control form-control-sm rounded-0" id="txt_descripcion" name="txt_descripcion" rows="3"></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <hr class="mb-4">

                        <div class="row">
                            <div class="form-group col-md-12">

                                <ul id="treeview" class="text-sm">

                                    <?php
                                    $aux = 0;
                                    foreach ($datos['opcionesMenu'] as $valor1)
                                    {
                                        $existe = 0;
                                        foreach ($valor1['subopcion'] as $val_chk){ 
                                            if ($val_chk['chk'] == 1){ $existe = $existe + 1; } 
                                        }

                                        if ($existe >= 1){ $checked = "checked"; }else{ $checked = ""; } 

                                        if($aux == 0) { echo "<div class='row'>"; }
                                    ?>
                                    <div class="form-group col-md-6">
                                        <li class="mt-3">

                                            <input type="checkbox" name="<?php echo 'chk1_' . $valor1['nombre_opcion']; ?>" id="<?php echo "chk1_" . $valor1["nombre_opcion"]; ?>" value="" <?php echo $checked; ?>>
                                            <label class="mb-1" for="<?php echo $valor1["nombre_opcion"]; ?>"><?php echo $valor1["nombre_opcion"]; ?></label>

                                            <ul id="treeview">

                                                <?php
                                                foreach ($valor1["subopcion"] as $valor2)
                                                {
                                                    if ($valor2["chk"] == 1){ $checked = "checked"; }else{ $checked = "";}

                                                    // Permisos a módulos solo para SYSADMIN
                                                    if ( in_array($valor2["cve_opcion"], array(7)) && $_SESSION['datosUsuario']['datosUsuario']['cveperfil_usuario'] == 1 ) {
                                                        //echo "Entra";
                                                    }else{
                                                        //echo "Fuera";
                                                    }

                                                ?>
                                                <li>
                                                    <input type="checkbox" name="<?php echo "chk2_" . $valor2["metodo_opcion"]; ?>" id="<?php echo "chk2_" . $valor2["metodo_opcion"]; ?>" value="<?php echo $valor2["cve_opcion"]; ?>" <?php echo $checked; ?> >
                                                    <label class="mb-1" for="<?php echo "chk2_" . $valor2["metodo_opcion"]; ?>" style=" font-weight: normal;"><?php echo $valor2["nombre_opcion"]; ?></label>

                                                    <ul id="treeview">
                                                    <?php
                                                    $opcion = $valor2['cve_opcion'];
                                                    foreach ($datos['opcionesPermisos'][$opcion] as $valor3)
                                                    {
                                                        //echo $valor3[cve_opcionpermiso];
                                                        if ($valor3['cveopcion_opcionpermiso'] == $valor2['cve_opcion']) { 

                                                            if ($valor3["chk"] == 1){ $checked = "checked"; }else{ $checked = "";}
                                                    ?>

                                                    <li>
                                                        <input type="checkbox" name="<?php echo "chk3_" . $valor3["nombrelogico_opcionpermiso"]; ?>" id="<?php echo "chk3_" . $valor3["nombrelogico_opcionpermiso"]; ?>" value="<?php echo $valor3["cve_opcionpermiso"]; ?>" <?php echo $checked; ?> >
                                                        <label class="mb-1" for="<?php echo "chk3_" . $valor3["nombrelogico_opcionpermiso"]; ?>" style=" font-weight: normal;"><?php echo $valor3["nombre_opcionpermiso"]; ?></label>
                                                    </li>
                                                    <?php
                                                        
                                                        }
                                                    }
                                                    ?>
                                                    </ul>

                                                </li>
                                                
                                                <?php
                                                }
                                                ?>
                                            </ul>

                                        </li>
                                    </div>

                                    <?php

                                        if($aux == 1){
                                            $aux = 0;
                                        }
                                        else{
                                            $aux++;
                                        }
                                        
                                        if($aux == 0) { echo "</div>"; }

                                    }
                                    ?>

                                </ul>

                            </div>

                        </div>

                        <input type="hidden" id="txt_id_perfil" name="txt_id_perfil" value="<?php echo $datos['datos_perfil']['id']; ?>">

                        <div class="row mt-4">
                            <div class="form-group col-12">
                                <button type="submit" class="btn btn-primary btn-sm" id="btn_guardar"><?php echo ( $_SESSION['metodo'] == 'editar' ) ? 'Actualizar' : 'Guardar' ; ?> perfil</button>
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

            // $('.select2').select2();
            
        });

        $('input[type="checkbox"]').change(function(e) {

            var checked = $(this).prop("checked"),
                container = $(this).parent(),
                siblings = container.siblings();

                //console.log (siblings);
                //alert ($(this).parent().siblings().children(":checkbox:checked").length);

            container.find('input[type="checkbox"]').prop({
                indeterminate: false,
                checked: checked
            });

            function checkSiblings(el) {

                var parent = el.parent().parent(),
                    all = true;

                el.siblings().each(function() {
                    return all = ($(this).children('input[type="checkbox"]').prop("checked") === checked);
                });

                if (all && checked) {

                    parent.children('input[type="checkbox"]').prop({
                    indeterminate: false,
                    checked: checked
                    });

                    checkSiblings(parent);

                } else if (all && !checked) {

                    parent.children('input[type="checkbox"]').prop("checked", checked);
                    parent.children('input[type="checkbox"]').prop("checked", (parent.find('input[type="checkbox"]:checked').length > 0));
                    checkSiblings(parent);

                } else {

                    el.parents("li").children('input[type="checkbox"]').prop({
                    //indeterminate: true,
                    checked: true
                    });

                }

            }

            checkSiblings(container);
        });


        $('#form_perfil').on('submit', function(e) {
            e.preventDefault();

            $("#btn_guardar").prop('disabled', true);

            $.ajax({
                url: $(this).attr('action'),
                data: $(this).serialize() + "&TOKEN=" + TOKEN,
                type: "POST",
            }).done( function(data) {

                var json_response = JSON.parse(data);

                console.log(json_response);

                const opciones = {
                    'success': () => {
                        if ( json_response.error == false ) {

                            setTimeout(function() {
                                toastr.success(json_response.message);
                                reset_form();
                            }, 500);
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
            $("#txt_perfil").val("");
            $("#txt_descripcion").val("");
            $("#txt_id_perfil").val("");
        }

    </script>

</body>

</html>