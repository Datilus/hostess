<?php

class Restaurante
{

    private RestauranteService $restauranteService;

    public function __construct()
    {
        $this->restauranteService = new RestauranteService();
    }

    public function agregar(): void
    {
        if ($_SERVER['REQUEST_METHOD'] != 'POST') {
            new DataStatusResponse(true, 405, [], 405, "Method Not Allowed", []);
        }

        $json = file_get_contents('php://input');
        $data = json_decode($json, true);

        $response = $this->restauranteService->saveRestaurant($data);

        if (!$response['ERROR']) {
            new DataStatusResponse(false, 0, [], 201, 'Categoria creada', [$response]);
        } else {
            new DataStatusResponse(true, 404, [], 404, 'Error al crear restaurante', []);
        }
    }

    public function actualizar($parametersURL): void
    {
        if ($_SERVER['REQUEST_METHOD'] != 'PUT') {
            new DataStatusResponse(true, 405, [], 405, "Method Not Allowed", []);
        }
        if (empty($parametersURL)) {
            new DataStatusResponse(true, 400, [], 400, "Clave on URL not valid", []);
        }

        $json          = file_get_contents('php://input');
        $data          = json_decode($json, true);
        $data['clave'] = $parametersURL[0];

        $response = $this->restauranteService->saveRestaurant($data);

        if (!$response['ERROR']) {
            new DataStatusResponse(false, 0, [], 200, 'Restaurante actualizado', [$response]);
        } else {
            new DataStatusResponse(true, 404, [], 404, 'Error al actualizar restaurante', []);
        }
    }

        public function encabezado($parametersURL): void
    {
        if ($_SERVER['REQUEST_METHOD'] != 'GET') {
            new DataStatusResponse(true, 405, [], 405, "Method Not Allowed", []);
        }
        if (empty($parametersURL)) {
            new DataStatusResponse(true, 400, [], 400, "Clave on URL not valid", []);
        }

        $data['flag'] = 2;
        $data['key']  = $parametersURL[0];

        $response = $this->restauranteService->getRestaurant($data);

        new DataStatusResponse(false, 0, [], 200, 'Restaurante encontrado', [$response]);
    }

        public function detalle($parametersURL): void
    {
        if ($_SERVER['REQUEST_METHOD'] != 'GET') {
            new DataStatusResponse(true, 405, [], 405, "Method Not Allowed", []);
        }
        if (empty($parametersURL)) {
            new DataStatusResponse(true, 400, [], 400, "Clave on URL not valid", []);
        }

        $data['flag'] = 1;
        $data['key']  = $parametersURL[0];

        $response = $this->restauranteService->getRestaurant($data);

        new DataStatusResponse(false, 0, [], 200, 'Restaurante encontrado', [$response]);
    }

    public function contador(): void
    {
        if ($_SERVER['REQUEST_METHOD'] != 'GET') {
            new DataStatusResponse(true, 405, [], 405, "Method Not Allowed", []);
        }

        $data['flag']   = 1;
        $data['row']    = 0;
        $data['rows']   = 0;
        $data['search'] = 0;

        $response = $this->restauranteService->dataListRestaurants($data);

        new DataStatusResponse(false, 0, [], 200, 'Restaurantes en total', $response);
    }

    public function buscar_clave($parametersURL): void
    {
        if ($_SERVER['REQUEST_METHOD'] != 'GET') {
            new DataStatusResponse(true, 405, [], 405, "Method Not Allowed", []);
        }

        $data['flag']   = 2;
        $data['row']    = $_GET['row'];
        $data['rows']   = $_GET['rows'];
        $data['search'] = empty($parametersURL) ? "" : $parametersURL[0];

        $response = $this->restauranteService->dataListRestaurants($data);

        new DataStatusResponse(false, 0, [], 200, 'Claves encontradas', $response);
    }

    public function buscar_detalle($parametersURL): void
    {
        if ($_SERVER['REQUEST_METHOD'] != 'GET') {
            new DataStatusResponse(true, 405, [], 405, "Method Not Allowed", []);
        }

        $data['flag']   = 3;
        $data['row']    = $_GET['row'];
        $data['rows']   = $_GET['rows'];
        $data['search'] = empty($parametersURL) ? "" : $parametersURL[0];

        $response = $this->restauranteService->dataListRestaurants($data);

        new DataStatusResponse(false, 0, [], 200, 'Restaurantes encontrados', $response);
    }
}