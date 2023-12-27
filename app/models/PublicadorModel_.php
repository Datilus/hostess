<?php

class PublicadorModel
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

        $query = "CALL sp_obtener_publicador(
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
            "ban"               => "",
            "id_publicador"     => 0,
            "id_congregacion"   => 0,
            "codigo_tipo"       => "",
            "fecha_bautismo"    => "",
            "nombre"            => "",
            "apellido_paterno"  => "",
            "apellido_materno"  => "",
            "genero"            => "",
            "fecha_nacimiento"  => "",
            "calle"             => "",
            "numero_casa"       => "",
            "codigo_colonia"    => "",
            "telefono"          => "",
            "movil"             => "",
            "id_grupo"          => 0,
            "json_contactos"    => [],
            "estatus"           => "",
            "id_usuario_accion" => ( empty($_SESSION["datos_usuario"]["ID_USUARIO"]) ) ? 0 : $_SESSION["datos_usuario"]["ID_USUARIO"],
            "search"            => "",
            "values"            => ""
        ];

        $params = array_merge($default_data, $data);

        $query = "CALL sp_guardar_publicador(
            '". $params['ban'] ."',
            '". $params['id_publicador'] ."',
            '". $params['id_congregacion'] ."',
            '". $params['codigo_tipo'] ."',
        ";

        if (!empty($params['fecha_bautismo']))
            $query .= "'". $params['fecha_bautismo'] ."',";
        else
            $query .= "NULL,";
        
        $query .= "
            '". $params['nombre'] ."',
            '". $params['apellido_paterno'] ."',
            '". $params['apellido_materno'] ."',
            '". $params['genero'] ."',
        ";

        if (!empty($params['fecha_nacimiento'])) 
            $query .= "'". $params['fecha_nacimiento'] ."',";
        else
            $query .= "NULL,";
        
        $query .= "
            '". $params['calle'] ."',
            '". $params['numero_casa'] ."',
            '". $params['codigo_colonia'] ."',
            '". $params['telefono'] ."',
            '". $params['movil'] ."',
            '". $params['id_grupo'] ."',
            '". $params['json_contactos'] ."',
            '". $params['estatus'] ."',
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
        $ban             = $datos_i['ban'];
        $row             = $datos_i['row'];
        $rows            = $datos_i['rows'];
        $id_congregacion = $datos_i['id_congregacion'];
        $search          = $datos_i['search'];

        $query = "CALL sp_data_list_publicador('$ban','$row','$rows','$id_congregacion','$search')";

        $consulta = $this->conexion->query($query) or die ($this->conexion->error());
        $respuesta = $this->conexion->consulta_assoc($consulta);

        $this->conexion->next_result();

        return $respuesta;
    }

}

?>