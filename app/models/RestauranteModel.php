<?php

class RestauranteModel
{
    public ConexionBD $conexionBD;

    public function __construct()
    {
        $this->conexionBD = ConexionBD::obtenerInstancia();
    }

    public function saveRestaurant($flag, $key, $keyHotel, $restaurant, $name, $speciality, $chef, $maxPersons,
                                   $sitting, $description, $jsonSchedules, $jsonImg, $status, $keyUser): array
    {
        $query = "CALL GUARDAR_RESTAURANTES(
            '$flag', 
            '$key', 
            '$keyHotel', 
            '$restaurant', 
            '$name', 
            '$speciality', 
            '$chef', 
            '$maxPersons',
            '$sitting', 
            '$description', 
            '$jsonSchedules', 
            '$jsonImg', 
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
    public function getRestaurant($flag, $key): array
    {
        $query = "CALL OBTEN_RESTAURANTES(
            '$flag',
            '$key'
        )";

        $inquiry  = $this->conexionBD->query($query);
        $response = $this->conexionBD->consulta_assoc($inquiry);

        $this->conexionBD->next_result();

        if (empty($response)) {
            new DataStatusResponse(true, 404, [], 404, "No data founded", []);
        }

        return $response;
    }

}
