<?php

class ValidateValues{

    private static $reglas = [

        "valor" => "",

        "nombre_logico" => "",

        "nombre_campo" => "",

        "tipo" => "string",

        "valor_default" => "",

        "requerido" => false,

        "caracteres_especiales" => true, // true = Permitidos, false = No permitidos

        "str_mayus" => "" // "" = default, true = Mayúsculas, false = Minúsculas

    ];
    
    private $valor_validado = "";



    public function validar($reglas = [])
    {
        $opciones_reglas = array_merge(self::$reglas, $reglas);

        // Nombre lógico es requerido
        if ( empty($opciones_reglas["nombre_logico"]) ) {

            $msg = "Es requerido asignarle un nombre lógico al campo.";
            $this->outputMensajeJSON($opciones_reglas["nombre_campo"], $msg, "warning");
        }


        // Si viene vacio el nombre del campo lo remplazamos por el nombre lógico para que el mensaje de error identifique el nombre del campo
		$opciones_reglas["nombre_campo"] = ( ! empty($opciones_reglas["nombre_campo"]) ) ? $opciones_reglas["nombre_campo"] : $opciones_reglas["nombre_logico"] ;


        // Quitamos espacios
        $opciones_reglas["valor"] = $this->quitar_espacios_rl($opciones_reglas["valor"]);


        // Validamos tipos
        if ( $opciones_reglas["tipo"] == "string" ) {

            if ( empty($opciones_reglas["valor"]) ) {

                $opciones_reglas["valor"] = "";
            }
        }elseif ( $opciones_reglas["tipo"] == "number" ){

            if ( empty($opciones_reglas["valor"]) || $opciones_reglas["valor"] == "0" || $opciones_reglas["valor"] == 0 ) {

                $opciones_reglas["valor"] = 0;
            }
        }elseif ( $opciones_reglas["tipo"] == "json_string" ){

            if ( $opciones_reglas["valor"] == "[]" ) {

                $opciones_reglas["valor"] = '[]'; 
            }elseif ( empty($opciones_reglas["valor"]) || $opciones_reglas["valor"] == '{}' ) {

                $opciones_reglas["valor"] = '{}'; 
            }
        }elseif ( $opciones_reglas["tipo"] == "email" ){

            if ( !empty($opciones_reglas["valor"]) ){ // Validamos que no venga vacio, por que si viene asi el validateEmail lo tomara como inválido

                if ( $this->validateEmail($opciones_reglas["valor"]) === false ) {

                    $msg = "Email inválido.";
                    $this->outputMensajeJSON($opciones_reglas["nombre_campo"], $msg, "warning");
                }
            }

            $opciones_reglas["valor"] = filter_var ( $opciones_reglas["valor"], FILTER_SANITIZE_EMAIL);

        }elseif ( $opciones_reglas["tipo"] == "date" ){

            if ( !empty($opciones_reglas["valor"]) ) { // el valor no debe ir vacio por date_create no trabaja con datos vacios

                $separadores_permitidos = ["/","-"]; // separadores permitidos
                $separador = "--";
                foreach ($separadores_permitidos as $value) 
                {

                    if ( substr_count($opciones_reglas["valor"], $value) == 2 ) {

                        $separador = $value;
                        break 1;
                    }
                }
                
                if ( empty($separador) ) {

                    $msg = "Formato de fecha no admitido.";
                    $this->outputMensajeJSON($opciones_reglas["nombre_campo"], $msg, "warning");
                }

                $dato = explode($separador, $opciones_reglas["valor"]);
                $fecha_nueva = $dato[2] . '-' . $dato[1] . '-' . $dato[0];

                $date = date_create($fecha_nueva);
                $fecha_format = date_format($date, 'Y-m-d');

                $opciones_reglas["valor"] = $fecha_format;
            }

        }


        // Requerido
        if ( 
            (
                empty($opciones_reglas["valor"])
                || $opciones_reglas["valor"] == 0
                || $opciones_reglas["valor"] == "0"
                || $opciones_reglas["valor"] < 0
                || $opciones_reglas["valor"] == "{}"
                || $opciones_reglas["valor"] == "[]"
            )
            && $opciones_reglas["requerido"] == true )
        {
            $msg = "El campo " . $opciones_reglas["nombre_campo"] . " es requerido.";
            $this->outputMensajeJSON($opciones_reglas["nombre_campo"], $msg, "warning");
        }


        // Caracteres especiales
        if ( $this->caracteres_especiales($opciones_reglas["valor"]) == false && $opciones_reglas["caracteres_especiales"] == false ) {

            $msg = "El campo " . $opciones_reglas["nombre_campo"] . " tiene caracteres especiales no permitidos.";
            $this->outputMensajeJSON($opciones_reglas["nombre_campo"], $msg, "warning");
        }


        // Convertimos a mayúsculas o minúsculas
        switch ( $opciones_reglas["str_mayus"] ) {
            case true:

                $opciones_reglas["valor"] = mb_strtoupper($opciones_reglas["valor"], 'UTF-8');
                break;
            case false:

                $opciones_reglas["valor"] = mb_strtolower($opciones_reglas["valor"], 'UTF-8');
                break;
            // default:
            //     $opciones_reglas["valor"] = $opciones_reglas["valor"];
        }


        $this->valor_validado = $opciones_reglas["valor"];

        return $this->valor_validado;
    }






    public function quitar_espacios_rl($valor) 
	{
		$resultado = rtrim($valor);
		$resultado = ltrim($resultado);

		return $resultado;
	}

    public function caracteres_especiales($valor)
	{
        $permitir = true;
		if (!empty($valor)) {

			if (is_null(json_decode($valor))) { // Por si pasamos un string en formato json nos lo deje pasar

				if (!preg_match('/^[0-9a-zA-Z\-ñÑáéíóúÁÉÍÓÚ@()+.,_ ]+$/', $valor)){

					$permitir = false;
				}
			}
		}

        return $permitir;
    }

    public function validateEmail($email) 
    {
        $regex = "/^([a-zA-Z0-9\.]+@+[a-zA-Z]+(\.)+[a-zA-Z]{2,3})$/";
        return preg_match($regex, $email) ? true : false ;
    }

    public function outputMensajeJSON(string $campo = "", string $msg, string $status = 'error') 
    {
        $envioDatos["status"] = $status;
        $envioDatos["campo"] = $campo;
		$envioDatos["msg"] = $msg;

		die(json_encode($envioDatos));
	}

}

?>