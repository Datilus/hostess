<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?php echo NOMBRE_SISTEMA; ?> | Log in</title>

    <link rel="shortcut icon" href="<?php echo RUTA_URL; ?>public/img/favicon.ico">

    <link rel="stylesheet" href="<?php echo RUTA_URL; ?>public/css/signin.css">
    <link rel="stylesheet" href="<?php echo RUTA_URL; ?>public/librerias/bootstrap-521/css/bootstrap.min.css">

    <style>
        .bd-placeholder-img {
            font-size: 1.125rem;
            text-anchor: middle;
            -webkit-user-select: none;
            -moz-user-select: none;
            user-select: none;
        }

        @media (min-width: 768px) {
            .bd-placeholder-img-lg {
                font-size: 3.5rem;
            }
        }

        .b-example-divider {
            height: 3rem;
            background-color: rgba(0, 0, 0, .1);
            border: solid rgba(0, 0, 0, .15);
            border-width: 1px 0;
            box-shadow: inset 0 .5em 1.5em rgba(0, 0, 0, .1), inset 0 .125em .5em rgba(0, 0, 0, .15);
        }

        .b-example-vr {
            flex-shrink: 0;
            width: 1.5rem;
            height: 100vh;
        }

        .bi {
            vertical-align: -.125em;
            fill: currentColor;
        }

        .nav-scroller {
            position: relative;
            z-index: 2;
            height: 2.75rem;
            overflow-y: hidden;
        }

        .nav-scroller .nav {
            display: flex;
            flex-wrap: nowrap;
            padding-bottom: 1rem;
            margin-top: -1px;
            overflow-x: auto;
            text-align: center;
            white-space: nowrap;
            -webkit-overflow-scrolling: touch;
        }
    </style>
</head>

<body class="text-center">

    <main class="form-signin w-100 m-auto">

        <div id="msgBox"></div>

        <form action="login/logIn" id="login" method="post">

            <div class="form-floating">
                <input type="text" class="form-control" id="txt_usuario" name="usuario" placeholder="Usuario" autocomplete="off" autofocus>
                <label for="txt_usuario">Usuario</label>
            </div>
            <div class="form-floating">
                <input type="password" class="form-control" id="txt_password" name="password" placeholder="Contraseña">
                <label for="txt_password">Contraseña</label>
            </div>

            <button class="w-100 btn btn-lg btn-primary" id="btn_entrar" type="submit">Entrar</button>

        </form>

    </main>

    <!-- jQuery -->
    <script src="<?php echo RUTA_URL; ?>public/librerias/<?php echo AdminLTE; ?>/plugins/jquery/jquery.min.js"></script>
    <!-- Bootstrap 4 -->
    <script src="<?php echo RUTA_URL; ?>public/librerias/bootstrap-521/js/bootstrap.bundle.min.js"></script>

    <script type="text/javascript">

        $('#login').on('submit', function(e) {

            e.preventDefault();

            $("#btn_entrar").prop('disabled', true);

            $.ajax({
                type: "POST",
                url: $(this).attr('action'),
                data: $(this).serialize(),
                beforeSend: function() {
                    // setting a timeout
                    msgBox("Iniciando...", "info", "Accesando");
                },
                success: function(datos) {

                    let json_response = JSON.parse(datos);

                    if ( json_response.error == false && json_response.meta_data.session_on == true ) {

                        location.href = 'home';
                    }else{

                        msgBox(json_response.message, "danger", "Error");

                        $("#btn_entrar").prop('disabled', false);
                    }
                }
            });
            
        });

        function msgBox(msg, tipo, alerta) 
        {
            $('#msgBox').css("display", "block");

            const alert_html = `
                <div class="alert alert-${tipo} alert-dismissible fade show" role="alert">
                    <strong>${alerta}</strong><br> ${msg}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            `;

            $("#msgBox").html(alert_html);
        }

    </script>

</body>

</html>