<?php

class Restaurante
{

    private RestauranteService $restauranteService;

    public function __construct()
    {
        $this->restauranteService = new RestauranteService();
    }

    public function agregar(): DataStatusResponse
    {
        if ($_SERVER['REQUEST_METHOD'] != 'POST') {
            return new DataStatusResponse(true, 405, [], 405, "Method Not Allowed", []);
        }

        $json = file_get_contents('php://input');
        $data = json_decode($json, true);

        $response = $this->restauranteService->saveRestaurant($data);

        if (!$response['ERROR']) {
            return new DataStatusResponse(false, 0, [], 201, 'Categoria creada', [$response]);
        } else {
            return new DataStatusResponse(true, 404, [], 404, 'Error al crear restaurante', []);
        }
    }

    public function actualizar($parametersURL): DataStatusResponse
    {
        if ($_SERVER['REQUEST_METHOD'] != 'PUT') {
            return new DataStatusResponse(true, 405, [], 405, "Method Not Allowed", []);
        }
        if (empty($parametersURL)) {
            return new DataStatusResponse(true, 400, [], 400, "Clave on URL not valid", []);
        }

        $json          = file_get_contents('php://input');
        $data          = json_decode($json, true);
        $data['clave'] = $parametersURL[0];

        $response = $this->restauranteService->saveRestaurant($data);

        if (!$response['ERROR']) {
            return new DataStatusResponse(false, 0, [], 200, 'Restaurante actualizado', [$response]);
        } else {
            return new DataStatusResponse(true, 404, [], 404, 'Error al actualizar restaurante', []);
        }
    }

    /**
     * @throws DataStatusResponse
     */
    public function encabezado($parametersURL): DataStatusResponse
    {
        if ($_SERVER['REQUEST_METHOD'] != 'GET') {
            return new DataStatusResponse(true, 405, [], 405, "Method Not Allowed", []);
        }
        if (empty($parametersURL)) {
            return new DataStatusResponse(true, 400, [], 400, "Clave on URL not valid", []);
        }

        $data['flag'] = 2;
        $data['key']  = $parametersURL[0];

        $response = $this->restauranteService->getRestaurant($data);

        return new DataStatusResponse(false, 0, [], 200, 'Restaurante encontrado', [$response]);
    }

    /**
     * @throws DataStatusResponse
     */
    public function detalle($parametersURL): DataStatusResponse
    {
        if ($_SERVER['REQUEST_METHOD'] != 'GET') {
            return new DataStatusResponse(true, 405, [], 405, "Method Not Allowed", []);
        }
        if (empty($parametersURL)) {
            return new DataStatusResponse(true, 400, [], 400, "Clave on URL not valid", []);
        }

        $data['flag'] = 1;
        $data['key']  = $parametersURL[0];

        $response = $this->restauranteService->getRestaurant($data);

        return new DataStatusResponse(false, 0, [], 200, 'Restaurante encontrado', [$response]);
    }
}