<?php

class UsuarioModel extends Usuario_
{
    public $conexion;
    
    public $dataReadParams;

    public function __construct()
    {
    	// inicializamos la clase para conectarnos a la bd
        $this->conexion = ConexionBD::obtenerInstancia();
    }

    
    // CONSULTAS
    //----------------------------------------
    public function getFromDataBase()
    {
        $query = "CALL sp_obtenerUsuario(
            '{$this->dataReadParams['ban']}',
            '{$this->dataReadParams['search']}'
        )";

        $consulta = $this->conexion->query($query);
        $respuesta = $this->conexion->consulta_assoc($consulta);

        $this->conexion->next_result();
        return $respuesta;
    }

    public function getUserExistByUser( $usuario )
    {
        $query = "SELECT fn_existeUsuarioPorUsuario('$usuario') AS EXISTE";
        $consulta = $this->conexion->query($query);
        $respuesta = $this->conexion->consulta_assoc($consulta);

        $this->conexion->next_result();

        return $respuesta['EXISTE'];
    }

    /* public function getAllFromDataBase()
    {
        $query = "CALL sp_obtenerUsuario(
            '{$this->dataReadParams['ban']}',
            '{$this->dataReadParams['search']}'
        )";

        $consulta = $this->conexion->query($query);
        $respuesta = $this->conexion->consulta_array($consulta);

        $this->conexion->next_result();

        return $respuesta;
    } */


    public function create()
    {
        $query = "CALL sp_guardar_usuario(
            '{$this->dataReadParams['ban']}',
            '{$this->dataReadParams['id_usuario']}',
            '{$this->dataReadParams['id_perfil']}',
            '{$this->dataReadParams['id_publicador']}',
            '{$this->dataReadParams['usuario']}',
            '{$this->dataReadParams['password']}',
            '{$this->dataReadParams['id_usuario_accion']}',
            '{$this->dataReadParams['search']}',
            '{$this->dataReadParams['values']}'
        )";

        $consulta = $this->conexion->query($query) or die ($this->conexion->error());
        $respuesta = $this->conexion->consulta_assoc($consulta);

        $this->conexion->next_result();

        return $respuesta;
    }


    public function getItemsMenu()
    {
        $query = "CALL sp_obtener_items_menu(
            '{$this->dataReadParams['ban']}',
            '{$this->dataReadParams['search']}'
        )";

        $consulta = $this->conexion->query($query) or die ($this->conexion->error());
        $respuesta = $this->conexion->consulta_array($consulta);

        $this->conexion->next_result();

        return $respuesta;

    }

    public function getPermissions()
    {
        $query = "CALL sp_obtener_permisos(
            '{$this->dataReadParams['ban']}',
            '{$this->dataReadParams['search']}'
        )";

        $consulta = $this->conexion->query($query) or die ($this->conexion->error());
        $respuesta = $this->conexion->consulta_array($consulta);

        $this->conexion->next_result();

        return $respuesta;

    }


    public function getDataTableList()
    {
        $query = "CALL sp_data_list_usuario(
            '{$this->dataReadParams['ban']}',
            '{$this->dataReadParams['row']}',
            '{$this->dataReadParams['rows']}',
            '{$this->dataReadParams['search']}'
        )";

        $consulta = $this->conexion->query($query) or die ($this->conexion->error());
        $respuesta = $this->conexion->consulta_assoc($consulta);

        $this->conexion->next_result();

        return $respuesta;
    }


}

?>