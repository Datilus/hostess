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

        $inquiry  = $this->conexion->query($query);
        $response = $this->conexion->consulta_assoc($inquiry);

        $this->conexion->next_result();

        if (empty($response['id'])) {
            new DataStatusResponse(true, 404, [], 404, "No data founded", []);
        }

        return $response;
    }

}
