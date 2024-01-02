<?php

class UsuarioModel
{
    public ConexionBD $conexion;
    
    public function __construct()
    {
        $this->conexion = ConexionBD::obtenerInstancia();
    }

    
    // CONSULTAS
    //----------------------------------------
    /**
     * @throws DataStatusResponse
     */
    public function getFromDataBase($ban, $criteria): array
    {
        $query = "CALL sp_obtener_usuario(
            '$ban',
            '$criteria'
        )";

        $consulta = $this->conexion->query($query);
        $respuesta = $this->conexion->consulta_assoc($consulta);

        $this->conexion->next_result();

        if (empty($respuesta['id'])) {
            throw new DataStatusResponse(true, 404, [], 404, "No data founded", []);
        }

        return $respuesta;
    }

}
