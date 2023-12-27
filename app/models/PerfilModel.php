<?php

class PerfilModel
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

        $query = "CALL sp_obtenerUsuario(
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
            "id_usuario" => "0",
            "id_perfil" => "0",
            "id_publicador" => "0",
            "usuario" => NULL,
            "password" => NULL,
            "id_usuario_accion" => ( empty($_SESSION["datos_usuario"]["ID_USUARIO"]) ) ? 0 : $_SESSION["datos_usuario"]["ID_USUARIO"] ,
            "search" => "",
            "values" => ""
        ];

        $params = array_merge($default_data, $data);

        $query = "CALL sp_guardar_usuario(
            '". $params['ban'] ."',
            '". $params['id_usuario'] ."',
            '". $params['id_perfil'] ."',
            '". $params['id_publicador'] ."',
            '". $params['usuario'] ."',
            '". $params['password'] ."',
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


    public function existeUsuarioPorUsuario( $usuario )
    {
        $query = "SELECT fn_existeUsuarioPorUsuario('$usuario') AS EXISTE";
        $consulta = $this->conexion->query($query);
        $respuesta = $this->conexion->consulta_assoc($consulta);

        $this->conexion->next_result();

        return $respuesta['EXISTE'];
    }


    public function verificarAccesoUsuarioPorUsuario( $usuario )
    {
        $query = "SELECT fn_verificarAccesoUsuarioPorUsuario('$usuario') AS ACCESO";
        $consulta = $this->conexion->query($query);
        $respuesta = $this->conexion->consulta_assoc($consulta);

        $this->conexion->next_result();

        return $respuesta['ACCESO'];
    }


    public function verificarAccesoUsuarioPorClave( $cve_usuario )
    {
        $query = "SELECT fn_verificarAccesoUsuarioPorClave('$cve_usuario') AS ACCESO";
        $consulta = $this->conexion->query($query);
        $respuesta = $this->conexion->consulta_assoc($consulta);

        $this->conexion->next_result();

        return $respuesta['ACCESO'];
    }


    public function data_list( $datos_i = array () )
    {
        $ban    = $datos_i['ban'];
        $row    = $datos_i['row'];
        $rows   = $datos_i['rows'];
        $search = $datos_i['search'];

        $query = "CALL sp_data_list_usuario('$ban','$row','$rows','$search')";

        $consulta = $this->conexion->query($query) or die ($this->conexion->error());
        $respuesta = $this->conexion->consulta_assoc($consulta);

        $this->conexion->next_result();

        return $respuesta;
    }


}

?>