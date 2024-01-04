<?php

class ProductoModel
{

    public ConexionBD $conexionBD;

    public function __construct()
    {
        $this->conexionBD = ConexionBD::obtenerInstancia();
    }

    public function saveProduct($flag, $key, $cveRestaurant, $cveCategory, $name, $slug, $description,
                                $price, $jsonOp, $status, $cveUser): array
    {
        $query = "CALL GUARDAR_MENU(
            '$flag',
            '$key',
            '$cveRestaurant',
            '$cveCategory',
            '$name',
            '$slug',
            '$description',
            '$price',
            '$jsonOp',
            '$status',
            '$cveUser'
        )";

        $inquiry  = $this->conexionBD->query($query);
        $response = $this->conexionBD->consulta_assoc($inquiry);

        $this->conexionBD->next_result();

        return $response;
    }

    /**
     * @throws DataStatusResponse
     */
    public function getProducts($flag, $key, $cveRestaurant, $cveCategory): array
    {
        $query = "CALL OBTEN_PRODUCTOS(
            '$flag',
            '$key',
            '$cveRestaurant',
            '$cveCategory'
        )";

        $inquiry  = $this->conexionBD->query($query);
        $response = $this->conexionBD->consulta_array($inquiry);

        $this->conexionBD->next_result();

        if (empty($response)) {
            throw new DataStatusResponse(true, 404, [], 404, "No data founded", []);
        }

        return $response;
    }
}