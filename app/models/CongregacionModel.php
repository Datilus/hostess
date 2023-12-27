<?php

class CongregacionModel
{
	private $props;

	// creamos la variable donde se instanciará la clase "conectar"
    public $conexion;
    

    public function __construct()
    {
        $this->props = new Props();

    	// inicializamos la clase para conectarnos a la bd
        $this->conexion = ConexionBD::obtenerInstancia();
    }

    
    // CONSULTAS
    //----------------------------------------
    public function consultar( $arrayParams = [] )
    {
        // parametros default
        $parametros = [
            "ban"=> 0,
            "search" => "",
            "opciones" => ["tipo" => "L"] 
        ];

        // combinamos parametros
        $parametros = array_merge($parametros, $arrayParams);

        $query = "CALL sp_obtener_congregacion(
            '{$parametros['ban']}',
            '{$parametros['search']}'
        )";

        $tipo_consulta = $this->props->tipoConsulta($parametros['opciones']['tipo']);

        $consulta = $this->conexion->query($query);
        $respuesta = $this->conexion->$tipo_consulta($consulta);

        $this->conexion->next_result();

        return $respuesta;
    }


    public function guardar( $data )
    {
        $default_data = [
            "ban" => "",
            "id_congregacion" => "0",
            "nombre" => "",
            "calle_salon" => "",
            "numero_salon" => "",
            "codigo_colonia" => NULL,
            "telefono_salon" => "",
            "id_usuario_accion" => ( empty($_SESSION["datos_usuario"]["ID_USUARIO"]) ) ? 0 : $_SESSION["datos_usuario"]["ID_USUARIO"] ,
            "search" => "",
            "values" => ""
        ];

        $params = array_merge($default_data, $data);

        $query = "CALL sp_guardar_congregacion(
            '". $params['ban'] ."',
            '". $params['id_congregacion'] ."',
            '". $params['nombre'] ."',
            '". $params['calle_salon'] ."',
            '". $params['numero_salon'] ."',
            '". $params['codigo_colonia'] ."',
            '". $params['telefono_salon'] ."',
            '". $params['id_usuario_accion'] ."',
            '". $params['search'] ."',
            '". $params['values'] ."'
        )";
        // echo $query;

        $consulta = $this->conexion->query($query) or die ($this->conexion->error());
        $respuesta = $this->conexion->consulta_assoc($consulta);

        $this->conexion->next_result();

        return $respuesta;
    }


    public function data_list( $datos_i = array () )
    {
        $ban    = $datos_i['ban'];
        $row    = $datos_i['row'];
        $rows   = $datos_i['rows'];
        $search = $datos_i['search'];

        $query = "CALL sp_data_list_congregacion('$ban','$row','$rows','$search')";

        // $consultar = $this->conexion->query($query);
        // $respuesta = $this->conexion->consulta_array($consultar);
        $consulta = $this->conexion->query($query) or die ($this->conexion->error());
        $respuesta = $this->conexion->consulta_assoc($consulta);

        $this->conexion->next_result();

        return $respuesta;
    }

}

?>