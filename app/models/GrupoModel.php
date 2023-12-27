<?php

class GrupoModel
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

        $query = "CALL sp_obtener_grupo(
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
            "id_grupo" => 0,
            "id_congregacion" => 0,
            "grupo" => "",
            "id_responsable" => 0,
            "id_auxiliar" => 0,
            "id_usuario_accion" => ( empty($_SESSION["datos_usuario"]["ID_USUARIO"]) ) ? 0 : $_SESSION["datos_usuario"]["ID_USUARIO"] ,
            "search" => "",
            "values" => ""
        ];

        $params = array_merge($default_data, $data);

        $query = "CALL sp_guardar_grupo(
            '". $params['ban'] ."',
            '". $params['id_grupo'] ."',
            '". $params['id_congregacion'] ."',
            '". $params['grupo'] ."',
            '". $params['id_responsable'] ."',
            '". $params['id_auxiliar'] ."',
            '". $params['id_usuario_accion'] ."',
            '". $params['search'] ."',
            '". $params['values'] ."'
        )";

        $consulta = $this->conexion->query($query) or die ($this->conexion->error());
        $respuesta = $this->conexion->consulta_assoc($consulta);

        $this->conexion->next_result();

        return $respuesta;
    }


    public function data_list( $datos_i = array () )
    {
        $ban             = $datos_i['ban'];
        $row             = $datos_i['row'];
        $rows            = $datos_i['rows'];
        $id_congregacion = $datos_i['id_congregacion'];
        $search          = $datos_i['search'];

        $query = "CALL sp_data_list_grupo('$ban','$row','$rows','$id_congregacion','$search')";

        // $consultar = $this->conexion->query($query);
        // $respuesta = $this->conexion->consulta_array($consultar);
        $consulta = $this->conexion->query($query) or die ($this->conexion->error());
        $respuesta = $this->conexion->consulta_assoc($consulta);

        $this->conexion->next_result();

        return $respuesta;
    }

}

?>