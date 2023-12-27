<?php

class CatalogoModel extends Catalogo_
{
    // creamos la variable donde se instanciará la clase "conectar"
    public $conexion;
    
    public $dataReadParams;

    public function __construct()
    {
    	// inicializamos la clase para conectarnos a la bd
        $this->conexion = ConexionBD::obtenerInstancia();
    }


    public function getFromDataBase()
    {
        $query = "CALL sp_obtenerCatalogos(
            '{$this->dataReadParams['ban']}',
            '{$this->dataReadParams['search']}'
        )";

        $consulta = $this->conexion->query($query);
        $respuesta = $this->conexion->consulta_array($consulta);

        $this->conexion->next_result();
        return $respuesta;
    }

    /*public function obtenerColonias($data = [])
    {
        $default_data = [
            "ban" => "0",
            "search" => "",
            "opciones" => ["tipo" => "L"] 
        ];

        $params = array_merge($default_data, $data);

        $query = "CALL sp_obtenerCatalogos(
            '". $params['ban'] ."',
            '". $params['search'] ."'
        )";

        $tipo_consulta = $this->props->tipoConsulta($params['opciones']['tipo']);

        $consulta = $this->conexion->query($query);
        $respuesta = $this->conexion->$tipo_consulta($consulta);

        $this->conexion->next_result();

        return $respuesta;
    }


    public function obtenerCatalogo($data = [])
    {
        $default_data = [
            "ban" => "0",
            "search" => "",
            "opciones" => ["tipo" => "L"] 
        ];

        $params = array_merge($default_data, $data);

        $query = "CALL sp_obtenerCatalogos(
            '". $params['ban'] ."',
            '". $params['search'] ."'
        )";

        $tipo_consulta = $this->props->tipoConsulta($params['opciones']['tipo']);

        $consulta = $this->conexion->query($query);
        $respuesta = $this->conexion->$tipo_consulta($consulta);

        $this->conexion->next_result();

        return $respuesta;
    }*/


}