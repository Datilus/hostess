<?php

interface RestauranteRepositoryInterface
{
    public function saveRestaurant($data);

    public function getRestaurant($data);
}

class RestauranteRepository implements RestauranteRepositoryInterface
{

    private RestauranteModel $restauranteModel;

    public function __construct()
    {
        $this->restauranteModel = new RestauranteModel();
    }

    public function saveRestaurant($data): array
    {
        $key           = $data['clave'];
        $keyHotel      = $data['cve_hotel'];
        $restaurant    = $data['restaurante'];
        $name          = $data['nombre'];
        $speciality    = $data['especialidad'];
        $chef          = $data['chef'];
        $maxPersons    = $data['max_personas'];
        $sitting       = $data['sitting'];
        $description   = $data['descripcion'];
        $jsonSchedules = $data['json_horarios'];
        $jsonImg       = $data['json_imagenes'];
        $status        = $data['estatus'];
        $keyUser       = $data['cve_usuario'];

        return $this->restauranteModel->saveRestaurant(1, $key, $keyHotel, $restaurant, $name, $speciality, $chef,
            $maxPersons, $sitting, $description, $jsonSchedules, $jsonImg, $status, $keyUser);
    }

    /**
     * @throws DataStatusResponse
     */
    public function getRestaurant($data): array
    {
        return $this->restauranteModel->getRestaurant($data['flag'], $data['key']);
    }

    public function dataListRestaurant($data): array
    {
        return $this->restauranteModel->dataListRestaurant($data['flag'], $data['row'], $data['rows'], $data['search']);
    }
}