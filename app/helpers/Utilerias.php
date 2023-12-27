<?php

class Utilerias{

    private static $instancia;

    /* public function __construct()
	{

	} */

    public static function obtenerInstanciaUtilerias() 
    {
        if ( !isset(self::$instancia) ) {

            self::$instancia = new self();
        }
        
        return self::$instancia;
    }


    public function redireccionar($ruta)
	{
		header(RUTA_APP . $ruta);
	}


    public function fecha_yyyymmdd($fecha, $separador, $separador_format)
    {
        if(!empty($fecha)){
            $dato = explode($separador, $fecha);
            $fecha_nueva = $dato[2] . $separador_format . $dato[1] . $separador_format . $dato[0];
            $date = date_create($fecha_nueva);
            $fecha_format = date_format($date, 'Y-m-d');
        }else{
            $fecha_format = "";
        }
        return $fecha_format;
    }


    public function fecha_ddmmyyyy($fecha, $separador, $separador_format)
    {
        if(!empty($fecha)){
            $dato = explode($separador, $fecha);
            $fecha_nueva = $dato[2] . $separador_format . $dato[1] . $separador_format . $dato[0];
            $date = date_create($fecha_nueva);
            $fecha_format = date_format($date, 'd-m-Y');
        }else{
            $fecha_format = "";
        }
        return $fecha_format;
    }


    public function fecha()
    {
        /* nombramos en una matriz los nombres de los meses y días*/
        $meses = array("enero", "febrero", "marzo", "abril", "mayo", "junio", "julio", "agosto", "septiembre", "octubre", "noviembre", "diciembre");
        $dias = array("Domingo", "Lunes", "Martes", "Miércoles", "Jueves", "Viernes", "Sábado");
        $dia = date('j'); // devuelve el día del mes
        $dia2 = date('w'); // devuelve el número de día de la semana
        $mes = date('n')-1; // devuelve el número del mes
        $ano = date('Y'); // devuelve el año
        $fecha = $dias[$dia2].", ".$dia." de ".$meses[$mes]." del ".$ano;
        return $fecha;
    }


    public function fechaCastellano ($fecha)
    {
        $fecha = substr($fecha, 0, 10);
        $numeroDia = date('d', strtotime($fecha));
        $dia = date('l', strtotime($fecha));
        $mes = date('F', strtotime($fecha));
        $anio = date('Y', strtotime($fecha));
        $dias_ES = array("Lunes", "Martes", "Miércoles", "Jueves", "Viernes", "Sábado", "Domingo");
        $dias_EN = array("Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday", "Sunday");
        $nombredia = str_replace($dias_EN, $dias_ES, $dia);
        $meses_ES = array("Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre");
        $meses_EN = array("January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December");
        $nombreMes = str_replace($meses_EN, $meses_ES, $mes);
        return $nombredia." ".$numeroDia." de ".$nombreMes." de ".$anio;
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


    // Función para quitar acentos de un texto
    public function quitarCaracteres($texto) {
        $caracteres = array(
            'á' => 'a',
            'é' => 'e',
            'í' => 'i',
            'ó' => 'o',
            'ú' => 'u',
            'Á' => 'A',
            'É' => 'E',
            'Í' => 'I',
            'Ó' => 'O',
            'Ú' => 'U',
            'ñ' => 'n',
            'Ñ' => 'N'
            // Agrega más caracteres
        );

        return strtr($texto, $caracteres);
    }


    public function formatNumberMobile($number_mobile)
    {
        // Eliminar espacios
        $number_mobile = preg_replace('/\s+/', '', $number_mobile);

        // Quitar símbolos y letras, dejar solo los números
        $number_mobile = preg_replace('/[^0-9]/', '', $number_mobile);
        
        return $number_mobile;
    }

}