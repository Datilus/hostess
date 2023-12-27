<?php
//session_start();

class LoginModel
{
	//creamos la variable donde se instanciará la clase "conectar"
    public $conexion;

    private $props;

    public function __construct() {
    	//inicializamos la clase para conectarnos a la bd
        $this->conexion = ConexionBD::obtenerInstancia();

        $this->props = new Props();
    }

    
    // Obtenemos datos del usuario
    /*public function loginUsuario($datos_i)
    {
        $BAN    = $datos_i['BAN'];
        $SEARCH = $datos_i['SEARCH'];

        $query = "CALL obtenerUsuario('$BAN','$SEARCH')";

        $tipo_consulta = match($datos_i['OPCIONES']['tipo']){
            'L' => 'consulta_array',
            'C' => 'numero_registros',
            'U' => 'consulta_assoc'
        };

        $consulta = $this->conexion->query($query);
        $respuesta = $this->conexion->$tipo_consulta($consulta);

        $this->conexion->next_result();

        return $respuesta;
    }*/


    public function obtener_items_menu( $arrayParams = [] )
    {
        // parametros default
        $parametros = [
            "ban"=> 0,
            "search" => "",
            "opciones" => ["tipo" => "L"] 
        ];

        // combinamos parametros
        $parametros = array_merge($parametros, $arrayParams);

        $query = "CALL sp_obtener_items_menu(
            '{$parametros['ban']}',
            '{$parametros['search']}'
        )";

        $tipo_consulta = $this->props->tipoConsulta($parametros['opciones']['tipo']);

        $c_menu = $this->conexion->query($query) or die ($this->conexion->error());
        $r_menu = $this->conexion->$tipo_consulta($c_menu);

        // print_r($r_menu);
        $this->conexion->next_result();

        return $r_menu;

    }

    public function obtener_permisos( $arrayParams = [] )
    {
        // parametros default
        $parametros = [
            "ban"=> 0,
            "search" => "",
            "opciones" => ["tipo" => "L"] 
        ];

        // combinamos parametros
        $parametros = array_merge($parametros, $arrayParams);

        $query = "CALL sp_obtener_permisos(
            '{$parametros['ban']}',
            '{$parametros['search']}'
        )";

        $tipo_consulta = $this->props->tipoConsulta($parametros['opciones']['tipo']);

        $c_menu = $this->conexion->query($query) or die ($this->conexion->error());
        $r_menu = $this->conexion->$tipo_consulta($c_menu);

        // print_r($r_menu);
        $this->conexion->next_result();

        return $r_menu;

    }


	
}

?>