<?php

class RestauranteService
{
    private RestauranteRepository $restauranteRepository;

    public function __construct()
    {
        $this->restauranteRepository = new RestauranteRepository();
    }

    public function saveRestaurant($data): array
    {
        $format = new Format($data);
        $data   = $format->transmute([
            'clave'         => 'numeric|trim',
            'cve_hotel'     => 'numeric|trim',
            'restaurante'   => 'trim',
            'nombre'        => 'trim',
            'especialidad'  => 'trim',
            'chef'          => 'trim',
            'max_personas'  => 'numeric|trim',
            'sitting'       => 'numeric|trim',
            'descripcion'   => 'trim',
            'json_horarios' => 'trim',
            'json_imagenes' => 'trim',
            'estatus'       => 'numeric|trim',
            'cve_usuario'   => 'numeric|trim'
        ]);
        $data   = $format->get_data_response();

        $validator = new Validator($data);
        $validator->validate([
            'clave'         => 'noSpecialCharacters',
            'cve_hotel'     => 'noSpecialCharacters',
            'restaurante'   => 'string|noSpecialCharacters|alphadash',
            'nombre'        => 'string|noSpecialCharacters|alphadash',
            'especialidad'  => 'string|noSpecialCharacters|alphadash',
            'chef'          => 'string|noSpecialCharacters|alphadash',
            'max_personas'  => 'noSpecialCharacters',
            'sitting'       => 'noSpecialCharacters',
            'descripcion'   => 'string|noSpecialCharacters|alphadash',
            'json_horarios' => 'string|noSpecialCharacters|alphadash',
            'json_imagenes' => 'string|noSpecialCharacters|alphadash',
            'estatus'       => 'noSpecialCharacters',
            'cve_usuario'   => 'noSpecialCharacters'
        ]);

        return $this->restauranteRepository->saveRestaurant($data);
    }

    /**
     * @throws DataStatusResponse
     */
    public function getRestaurant($data): array
    {
        $format = new Format($data);
        $data   = $format->transmute([
            'flag' => 'numeric|trim',
            'key'  => 'numeric|trim'
        ]);
        $data   = $format->get_data_response();

        $validator = new Validator($data);
        $validator->validate([
            'flag' => 'noSpecialCharacters',
            'key'  => 'noSpecialCharacters'
        ]);

        return $this->restauranteRepository->getRestaurant($data);
    }

    public function dataListRestaurants(array $data): array
    {
        $format = new Format($data);
        $data   = $format->transmute([
            'flag'   => 'numeric|trim',
            'row'    => 'numeric|trim',
            'rows'   => 'numeric|trim',
            'search' => 'trim'
        ]);
        $data   = $format->get_data_response();

        $validator = new Validator($data);
        $validator->validate([
            'flag'   => 'noSpecialCharacters',
            'row'    => 'noSpecialCharacters',
            'rows'   => 'noSpecialCharacters',
            'search' => 'noSpecialCharacters'
        ]);

        return $this->restauranteRepository->dataListRestaurant($data);
    }
}