<?php

class Categoria
{
    private CategoriaService $categoriaService;

    public function __construct()
    {
        $this->categoriaService = new CategoriaService();
    }

    public function agregar(): void
    {
        if ($_SERVER['REQUEST_METHOD'] != 'POST') {
            new DataStatusResponse(true, 405, [], 405, "Method Not Allowed", []);
        }

        $json = file_get_contents('php://input');
        $data = json_decode($json, true);

        $response = $this->categoriaService->saveCategory($data);

        if (!$response['ERROR']) {
            new DataStatusResponse(false, 0, [], 201, 'Categoria creada', [$response]);
        } else {
            new DataStatusResponse(true, 404, [], 404, 'Error al crear categoria', []);
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

        $response = $this->categoriaService->saveCategory($data);

        if (!$response['ERROR']) {
            new DataStatusResponse(false, 0, [], 200, 'Categoria actualizada', [$response]);
        } else {
            new DataStatusResponse(true, 404, [], 404, 'Error al actualizar categoria', []);
        }
    }

    /**
     * @throws DataStatusResponse
     */
    public function encabezado($parametersURL): void
    {
        if ($_SERVER['REQUEST_METHOD'] != 'GET') {
            new DataStatusResponse(true, 405, [], 405, "Method Not Allowed", []);
        }
        if (empty($parametersURL)) {
            new DataStatusResponse(true, 400, [], 400, "Clave on URL not valid", []);
        }

        $data['flag']          = 1;
        $data['key']           = $parametersURL[0];
        $data['keyRestaurant'] = 0;

        $response = $this->categoriaService->getCategories($data);

        new DataStatusResponse(false, 0, [], 200, 'Categoria encontrada', $response);
    }

    /**
     * @throws DataStatusResponse
     */
    public function detalle($parametersURL): void
    {
        if ($_SERVER['REQUEST_METHOD'] != 'GET') {
            new DataStatusResponse(true, 405, [], 405, "Method Not Allowed", []);
        }
        if (empty($parametersURL)) {
            new DataStatusResponse(true, 400, [], 400, "Clave on URL not valid", []);
        }

        $data['flag']          = 2;
        $data['key']           = $parametersURL[0];
        $data['keyRestaurant'] = 0;

        $response = $this->categoriaService->getCategories($data);

        new DataStatusResponse(false, 0, [], 200, 'Categoria encontrada', $response);
    }

    /**
     * @throws DataStatusResponse
     */
    public function restaurante($parametersURL): void
    {
        if ($_SERVER['REQUEST_METHOD'] != 'GET') {
            new DataStatusResponse(true, 405, [], 405, "Method Not Allowed", []);
        }
        if (empty($parametersURL)) {
            new DataStatusResponse(true, 400, [], 400, "Clave on URL not valid", []);
        }

        $data['flag']          = 3;
        $data['key']           = 0;
        $data['keyRestaurant'] = $parametersURL[0];

        $response = $this->categoriaService->getCategories($data);

        new DataStatusResponse(false, 0, [], 200, 'Categoria encontrada', $response);
    }
}
