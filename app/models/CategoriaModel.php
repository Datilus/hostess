<?php

class CategoriaModel
{

    public ConexionBD $conexionBD;

    public function __construct()
    {
        $this->conexionBD = ConexionBD::obtenerInstancia();
    }

    public function saveCategory($flag, $key, $keyRestaurant, $category, $name, $status, $keyUser): array
    {
        $query = "CALL GUARDAR_CATEGORIAS(
            '$flag',
            '$key',
            '$keyRestaurant',
            '$category',
            '$name',
            '$status',
            '$keyUser'
        )";

        $inquiry  = $this->conexionBD->query($query);
        $response = $this->conexionBD->consulta_assoc($inquiry);

        $this->conexionBD->next_result();

        return $response;
    }

    /**
     * @throws DataStatusResponse
     */
    public function getCategories($flag, $key, $keyRestaurant): array
    {
        $query = "CALL OBTEN_CATEGORIAS(
            '$flag',
            '$key',
            '$keyRestaurant'
        )";

        $inquiry  = $this->conexionBD->query($query);
        $response = $this->conexionBD->consulta_array($inquiry);

        $this->conexionBD->next_result();

        if (empty($response)) {
            new DataStatusResponse(true, 404, [], 404, "No data founded", []);
        }

        return $response;
    }

}
