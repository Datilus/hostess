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

        let lista_contactos_emergencia = [];
        localStorage.removeItem('contactos_emergencia');
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

                    <form id="form_<?php echo $_SESSION["controlador"]; ?>" action="<?php echo RUTA_URL . $_SESSION["controlador"]; ?>/guardar" method="post" autocomplete="off">

                        <?php
                        if ( $_SESSION['metodo'] != 'editar'  ) {
                            echo '<h4 class="mb-4">Nuevo publicador</h4>';
                        }else{
                            echo '<h4 class="mb-4">Actualizar publicador: ' . $datos['datos_publicador']['nombre'] . ' ' . $datos['datos_publicador']['apellido_paterno'] . ' ' . $datos['datos_publicador']['apellido_materno'] . '</h4>';
                        }
                        ?>

                        <div class="row">
                            <div class="form-group col-md-12">
                                <div class="form-group row mb-0">
                                    <label class="col-sm-3 col-md-2 col-lg-2 col-form-label font-weight-normal text-sm pb-0">Tipo *</label>
                                    <div class="col-sm-8 col-md-6 col-lg-4">
                                        <select class="form-control form-control-sm rounded-0" id="cmb_tipo" name="cmb_tipo" style="width: 100%;">
                                            <option value="">TIPO</option>
                                            <?php
                                            foreach ($datos['tipo'] as $key => $val){
                                                $selected_tipo = ($key == $datos['datos_publicador']['codigo_tipo'] ) ? "selected" : "" ;
                                                echo "<option value='" . $key . "' ". $selected_tipo ." >" . mb_strtoupper($val) . "</option>";
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="form-group col-md-12 <?php echo ( $_SESSION['metodo'] == 'editar' ) ? 'mb-0' : '' ; ?>">
                                <div class="form-group row mb-0">
                                    <label class="col-sm-3 col-md-2 col-lg-2 col-form-label font-weight-normal text-sm pb-0">Fecha bautismo</label>
                                    <div class="col-sm-4 col-md-3 col-lg-2">
                                    <input type="text" class="form-control form-control-sm rounded-0" id="txt_fecha_bautismo" name="txt_fecha_bautismo" 
                                    value="<?php echo $datos['datos_publicador']['fecha_bautismo'] ?>" 
                                    data-inputmask-alias="datetime" 
                                    data-inputmask-inputformat="dd-mm-yyyy" 
                                    data-mask="" 
                                    inputmode="numeric" 
                                    autocomplete="off"
                                    onKeyPress="return Utilerias.soloNumeros(event);">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <?php
                        if ( $_SESSION['metodo'] == 'editar' ){
                        ?>
                        <div class="row">
                            <div class="form-group col-md-12">
                                <div class="form-group row mb-0">
                                    <label class="col-sm-3 col-md-2 col-lg-2 col-form-label font-weight-normal text-sm pb-0"></label>
                                    <div class="col-sm-4 col-md-3 col-lg-2">
                                        <span class="text-muted">
                                            <small>Años bautizad@: <?php echo ( empty($datos['datos_publicador']['tiempo_bautizado']) ) ? "-" : $datos['datos_publicador']['tiempo_bautizado'] . " años" ; ?></small>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php
                        }
                        ?>

                        <div class="row">
                            <div class="form-group col-md-12">
                                <div class="form-group row mb-0">
                                    <label class="col-sm-3 col-md-2 col-lg-2 col-form-label font-weight-normal text-sm pb-0">Nombre *</label>
                                    <div class="col-sm-8 col-md-6 col-lg-4">
                                        <input type="text" class="form-control form-control-sm rounded-0" id="txt_nombre" name="txt_nombre" 
                                        value="<?php echo $datos['datos_publicador']['nombre']; ?>"
                                        autocomplete="off">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="form-group col-md-12">
                                <div class="form-group row mb-0">
                                    <label class="col-sm-3 col-md-2 col-lg-2 col-form-label font-weight-normal text-sm pb-0">Apellido paterno *</label>
                                    <div class="col-sm-8 col-md-6 col-lg-4">
                                        <input type="text" class="form-control form-control-sm rounded-0" id="txt_apellido_paterno" name="txt_apellido_paterno" 
                                        value="<?php echo $datos['datos_publicador']['apellido_paterno']; ?>"
                                        autocomplete="off">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="form-group col-md-12">
                                <div class="form-group row mb-0">
                                    <label class="col-sm-3 col-md-2 col-lg-2 col-form-label font-weight-normal text-sm pb-0">Apellido materno</label>
                                    <div class="col-sm-8 col-md-6 col-lg-4">
                                        <input type="text" class="form-control form-control-sm rounded-0" id="txt_apellido_materno" name="txt_apellido_materno" 
                                        value="<?php echo $datos['datos_publicador']['apellido_materno']; ?>"
                                        autocomplete="off">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="form-group col-md-12">
                                <div class="form-group row mb-0">
                                    <label class="col-sm-3 col-md-2 col-lg-2 col-form-label font-weight-normal text-sm pb-0">Género *</label>
                                    <div class="col-sm-4 col-md-3 col-lg-2">
                                        <select class="form-control form-control-sm rounded-0" id="cmb_genero" name="cmb_genero" style="width: 100%;">
                                            <option value="">GÉNERO</option>
                                            <?php
                                            foreach ($datos['genero'] as $key => $val){
                                                $selected_genero = ($key == $datos['datos_publicador']['genero'] ) ? "selected" : "" ;
                                                echo "<option value='" . $key . "' ". $selected_genero ." >" . mb_strtoupper($val) . "</option>";
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="form-group col-md-12 <?php echo ( $_SESSION['metodo'] == 'editar' ) ? 'mb-0' : '' ; ?>">
                                <div class="form-group row mb-0">
                                    <label class="col-sm-3 col-md-2 col-lg-2 col-form-label font-weight-normal text-sm pb-0">Fecha nacimiento</label>
                                    <div class="col-sm-4 col-md-3 col-lg-2">
                                    <input type="text" class="form-control form-control-sm rounded-0" id="txt_fecha_nacimiento" name="txt_fecha_nacimiento" 
                                    value="<?php echo $datos['datos_publicador']['fecha_nacimiento'] ?>" 
                                    data-inputmask-alias="datetime" 
                                    data-inputmask-inputformat="dd-mm-yyyy" 
                                    data-mask="" 
                                    inputmode="numeric" 
                                    autocomplete="off"
                                    onKeyPress="return Utilerias.soloNumeros(event);">
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <?php
                        if ( $_SESSION['metodo'] == 'editar' ){
                        ?>
                        <div class="row">
                            <div class="form-group col-md-12">
                                <div class="form-group row mb-0">
                                    <label class="col-sm-3 col-md-2 col-lg-2 col-form-label font-weight-normal text-sm pb-0"></label>
                                    <div class="col-sm-4 col-md-3 col-lg-2">
                                        <span class="text-muted">
                                            <small>Edad: <?php echo ( empty($datos['datos_publicador']['edad']) ) ? "-" : $datos['datos_publicador']['edad'] . " años" ; ?></small>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php
                        }
                        ?>

                        <div class="row">
                            <div class="form-group col-md-12">
                                <div class="form-group row mb-0">
                                    <label class="col-sm-3 col-md-2 col-lg-2 col-form-label font-weight-normal text-sm pb-0">Calle *</label>
                                    <div class="col-sm-8 col-md-6 col-lg-4">
                                        <input type="text" class="form-control form-control-sm rounded-0" id="txt_calle_casa" name="txt_calle_casa" 
                                        value="<?php echo $datos['datos_publicador']['calle_casa']; ?>"
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
                                        value="<?php echo $datos['datos_publicador']['numero_casa']; ?>"
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
                                                $selected_colonia = (int) ($val["CLAVE"] == $datos['datos_publicador']['codigo_colonia'] ) ? "selected" : "" ;
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
                                    <label class="col-sm-3 col-md-2 col-lg-2 col-form-label font-weight-normal text-sm pb-0">Teléfono</label>
                                    <div class="col-sm-4 col-md-3 col-lg-2">
                                        <input type="text" class="form-control form-control-sm rounded-0" id="txt_telefono" name="txt_telefono" 
                                        value="<?php echo $datos['datos_publicador']['telefono']; ?>"
                                        inputmode="numeric"
                                        onKeyPress="return Utilerias.soloNumeros(event);" 
                                        autocomplete="off">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="form-group col-md-12">
                                <div class="form-group row mb-0">
                                    <label class="col-sm-3 col-md-2 col-lg-2 col-form-label font-weight-normal text-sm pb-0">Celular</label>
                                    <div class="col-sm-4 col-md-3 col-lg-2">
                                        <input type="text" class="form-control form-control-sm rounded-0" id="txt_movil" name="txt_movil" 
                                        value="<?php echo $datos['datos_publicador']['movil']; ?>"
                                        inputmode="numeric"
                                        onKeyPress="return Utilerias.soloNumeros(event);" 
                                        autocomplete="off">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="form-group col-md-12">
                                <div class="form-group row mb-0">
                                    <label class="col-sm-3 col-md-2 col-lg-2 col-form-label font-weight-normal text-sm pb-0">Grupo *</label>
                                    <div class="col-sm-8 col-md-6 col-lg-4">
                                        <select class="form-control form-control-sm rounded-0" id="cmb_grupo" name="cmb_grupo" style="width: 100%;">
                                            <option value="">SELECCIONAR GRUPO</option>
                                            <?php
                                            foreach ($datos['grupos'] as $val){
                                                $selected_tipo = ($val['ID'] == $datos['datos_publicador']['id_grupo'] ) ? "selected" : "" ;
                                                echo "<option value='" . $val['ID'] . "' ". $selected_tipo ." >" . mb_strtoupper($val['GRUPO']) . "</option>";
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <h5 class="mb-3 mt-3">Datos de emergencia</h5>

                        <div class="row">
                            <div class="form-group col-md-6 col-lg-3 mb-1">
                                <div class="btn btn-default btn-sm btn-flat" id="btn_contacto">Añadir contácto</div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="form-group col-md-12 col-lg-6 table-responsive mb-0">
                                <table id="gridContactos" class="table table-bordered table-striped dataTable dtr-inline" style="font-size: 11px; width: 100%">
                                    <thead>
                                        <tr>
                                            <th>Nombre</th>
                                            <th>Domicilio</th>
                                            <th>Contácto</th>
                                            <th>Parentesco</th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                </table>
                            </div>
                        </div>

                        <div class="row mt-4">
                            <div class="form-group col-md-12">
                                <div class="form-group row mb-0">
                                    <label class="col-sm-3 col-md-2 col-lg-2 col-form-label font-weight-normal text-sm pb-0">Estatus publicador</label>
                                    <div class="col-sm-4 col-md-3 col-lg-2">
                                        <select class="form-control form-control-sm rounded-0" id="cmb_estatus" name="cmb_estatus" style="width: 100%;">
                                            <?php
                                            foreach ($datos['estatus'] as $key => $val){
                                                $selected_estatus = ($key == $datos['datos_publicador']['estatus'] ) ? "selected" : "" ;
                                                echo "<option value='" . $key . "' ". $selected_estatus ." >" . mb_strtoupper($val) . "</option>";
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <input type="hidden" id="txt_id_publicador" name="txt_id_publicador" value="<?php echo $datos['datos_publicador']['id']; ?>">

                        <div class="row mt-4">
                            <div class="form-group col-12">
                                <button type="submit" class="btn btn-primary btn-sm btn-flat" id="btn_guardar"><?php echo ( $_SESSION['metodo'] == 'editar' ) ? 'Actualizar' : 'Guardar' ; ?> publicador</button>
                                <button type="button" class="btn btn-primary btn-sm btn-flat" id="btn_cerrar">Cerrar</button>
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
    <div class="modal fade" id="modal_contacto" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content shadow-none">
                <div class="modal-header">
                    <h5 class="modal-title" id="myModalLabel">Contácto emergencia</h5>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="form-group col-12 mb-1">
                            <label class="form-label font-weight-normal text-sm mb-0">Nombre del contacto</label>
                            <input type="text" class="form-control rounded-0" id="txt_nombre_contacto" name="txt_nombre_contacto">
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-12 mb-1">
                            <label class="form-label font-weight-normal text-sm mb-0">Domicilio</label>
                            <input type="text" class="form-control rounded-0" id="txt_domicilio_contacto" name="txt_domicilio_contacto">
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-12 mb-1">
                            <label class="form-label font-weight-normal text-sm mb-0">Número de contacto</label>
                            <input type="text" class="form-control rounded-0" id="txt_numero_contacto" name="txt_numero_contacto"
                            inputmode="numeric"
                            onKeyPress="return Utilerias.soloNumeros(event);" >
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-12 mb-1">
                            <label class="form-label font-weight-normal text-sm mb-0">Parentesco</label>
                            <input type="text" class="form-control rounded-0" id="txt_parentesco_contacto" name="txt_parentesco_contacto">
                        </div>
                    </div>
                    
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary btn-flat" id="btn_agregar_contacto">Agregar</button>
                    <div class="btn btn-secondary btn-flat" data-dismiss="modal">Cerrar</div>
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

            $('#txt_fecha_bautismo, #txt_fecha_nacimiento').inputmask('dd-mm-yyyy', {
                'placeholder': 'dd-mm-yyyy'
            });

            $('.select2').select2();

            tablaContactos = $('#gridContactos').DataTable( {    
                "responsive": false,
                "searching" : false,
                "paging"    : false,
                "lengthMenu": ["All"],
                "ordering"  : false,
                "info"      : false,
                "columnDefs": [
                    {"width": "15%", "targets": 3},
                    {"width": "8%","className": "text-center","targets": 4}
                ],
                "bJQueryUI":true,
                "oLanguage": UI.SpanishDataTable()
            });

            if ( ACCION == 'editar' ) {

                localStorage.setItem("contactos_emergencia", JSON.stringify(<?php echo $datos['datos_publicador']['json_contactos'] ?>));

                setTimeout(function (){  
                    
                    cargar_contactos_emergencia(
                        obtener_localStorage("contactos_emergencia")
                    );

                }, 300);
            }

        });

        $('#cmb_colonia').on('select2:open', function() {
            var inputElement = document.querySelector('.select2-search__field');
            inputElement.focus();
        });

        let modal_contacto = new bootstrap.Modal(document.getElementById("modal_contacto"), {
            backdrop: 'static',
            keyboard: false
        });

        $('#btn_contacto').on('click', function(){
            modal_contacto.show();
        });

        document.getElementById('btn_cerrar').addEventListener('click', function(e) {
            window.top.iFrameInstance.removeActiveTab();
        });

        $('#form_publicador').on('submit', function(e) {
            e.preventDefault();

            let lista_contactos = obtener_localStorage("contactos_emergencia");
            let json_contactos_emergencia = JSON.stringify(lista_contactos);

            // $("#btn_guardar").prop('disabled', true);

            $.ajax({
                url: $(this).attr('action'),
                data: $(this).serialize() + "&json_contactos_emergencia="+ json_contactos_emergencia + "&TOKEN=" + TOKEN,
                type: "POST",
            }).done( function(data) {

                var json_response = JSON.parse(data);

                const opciones = {
                    'success': () => {
                        if ( json_response.error == false ) {

                            UI.create_tab('Consultar publicador', RUTA_URL + CONTROLADOR + '/consultarPublicador');
                            const message = JSON.stringify({
                                status: json_response.meta_data.status_msg,
                                msg: json_response.message,
                                accion: ACCION
                            });
                            
                            setTimeout(function() {
                                var iframeDestino = window.parent.document.getElementById("consultar-publicador");
                                iframeDestino.contentWindow.postMessage(message, RUTA_URL + CONTROLADOR + '/consultarPublicador');

                                if ( ACCION != 'editar' ) {
                                    setTimeout(function() {
                                        reset_form();
                                    }, 500);
                                }

                            }, 1000);

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




        // --- Agregar contácto

        $('#btn_agregar_contacto').on( 'click', function (e) {
            e.preventDefault();
            
            let nombre_contacto  = $( "#txt_nombre_contacto" ).val();
            let direccion_contacto  = $( "#txt_domicilio_contacto" ).val();
            let numero_contacto  = $( "#txt_numero_contacto" ).val();
            let parentesco_contacto  = $( "#txt_parentesco_contacto" ).val();

            if ( nombre_contacto == '' ) {
                toastr.warning("Favor de escribir el nombre del contacto.");
            } else if ( direccion_contacto == "" ) {
                toastr.warning("Favor de escribir la dirección completa del contacto");
            } else if ( numero_contacto == "" ) {
                toastr.warning("Favor de escribir el número del contacto");
            } else if ( parentesco_contacto == "" ) {
                toastr.warning("Favor de escribir el parentesco con el contacto");
            } else {

                let item_contacto = {
                    "nombre"    : nombre_contacto.toUpperCase(),
                    "direccion" : direccion_contacto.toUpperCase(),
                    "numero"    : numero_contacto,
                    "parentesco": parentesco_contacto.toUpperCase()
                };

                let lista_contactos_emergencia = new Array; // Reiniciemos la variable para obtener dato de localStorage
                lista_contactos_emergencia = obtener_localStorage("contactos_emergencia"); //Si el localSrorage no existe inicia en array vacio

                lista_contactos_emergencia.push(item_contacto);

                guardar_localstorage("contactos_emergencia", lista_contactos_emergencia);
                clear_form_contactos();
                modal_contacto.hide();

                setTimeout(function (){
                    cargar_contactos_emergencia(
                        obtener_localStorage("contactos_emergencia")
                    );
                }, 500);
                
            }

        });

        function cargar_contactos_emergencia( lista_contactos ) 
        {
            tablaContactos.clear().draw();
            let i = 0;
            $(lista_contactos).each( function(key, val) {
                tablaContactos.row.add( [
                    val.nombre,
                    val.direccion,
                    val.numero,
                    val.parentesco,
                    "<div class='btn btn-default btn-sm badge' title='Borrar' onclick=\"borrar_contacto_emergencia('" + i + "')\"><i class='fas fa-minus-circle' style='font-size:10px;'></i></div>"
                ] ).draw( false );
                i++;
            }); 
        }

        function borrar_contacto_emergencia( indice )
        {
            let lista_contactos_emergencia = obtener_localStorage("contactos_emergencia");
            let eliminados = lista_contactos_emergencia.splice(indice, 1); // 1 es la cantidad de elemento a eliminar

            guardar_localstorage("contactos_emergencia", lista_contactos_emergencia);

            setTimeout(function (){
                cargar_contactos_emergencia(
                    obtener_localStorage("contactos_emergencia")
                );
            }, 500);

        }

        function clear_form_contactos()
        {
            $("#txt_nombre_contacto").val("");
            $("#txt_domicilio_contacto").val("");
            $("#txt_numero_contacto").val("");
            $("#txt_parentesco_contacto").val("");
        }

        // --- Fin agregar contácto




        function reset_form() 
        {
            document.getElementById("cmb_tipo").selectedIndex = "0";
            $("#txt_fecha_bautismo").val("");
            $("#txt_nombre").val("");
            $("#txt_apellido_paterno").val("");
            $("#txt_apellido_materno").val("");
            document.getElementById("cmb_genero").selectedIndex = "0";
            $("#txt_fecha_nacimiento").val("");
            $("#txt_calle_casa").val("");
            $("#txt_numero_domicilio").val("");
            $("#cmb_colonia").val('').trigger('change');
            $("#txt_telefono").val("");
            $("#txt_movil").val("");
            $("#txt_id_publicador").val("");
            document.getElementById("cmb_grupo").selectedIndex = "0";
        }

    </script>

</body>

</html>