<?php

class Producto
{
    private ProductoService $productoService;

    public function __construct()
    {
        $this->productoService = new ProductoService();
    }

    public function agregar(): DataStatusResponse
    {
        if ($_SERVER['REQUEST_METHOD'] != 'POST') {
            return new DataStatusResponse(true, 405, [], 405, "Method Not Allowed", []);
        }

        $json = file_get_contents('php://input');
        $data = json_decode($json, true);

        $response = $this->productoService->saveProduct($data);

        if (!$response['ERROR']) {
            return new DataStatusResponse(false, 0, [], 201, 'Producto creado', [$response]);
        } else {
            return new DataStatusResponse(true, 404, [], 404, 'Error al crear producto', []);
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

        $response = $this->productoService->saveProduct($data);

        if (!$response['ERROR']) {
            return new DataStatusResponse(false, 0, [], 200, 'Producto actualizado', [$response]);
        } else {
            return new DataStatusResponse(true, 404, [], 404, 'Error al actualizar producto', []);
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

        $data['flag'] = 1;
        $data['key']  = $parametersURL[0];

        $response = $this->productoService->getProductsByFlag($data);

        return new DataStatusResponse(false, 0, [], 200, 'Producto encontrado', $response);
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

        $data['flag'] = 2;
        $data['key']  = $parametersURL[0];

        $response = $this->productoService->getProductsByFlag($data);

        return new DataStatusResponse(false, 0, [], 200, 'Producto encontrado', $response);
    }

    /**
     * @throws DataStatusResponse
     */
    public function porRestaurante($parametersURL): DataStatusResponse
    {
        if ($_SERVER['REQUEST_METHOD'] != 'GET') {
            return new DataStatusResponse(true, 405, [], 405, "Method Not Allowed", []);
        }
        if (empty($parametersURL)) {
            return new DataStatusResponse(true, 400, [], 400, "Clave on URL not valid", []);
        }

        $data['flag']          = 3;
        $data['keyRestaurant'] = $parametersURL[0];

        $response = $this->productoService->getProductsByRestaurant($data);

        return new DataStatusResponse(false, 0, [], 200, 'Productos encontrados', $response);
    }

    /**
     * @throws DataStatusResponse
     */
    public function restauranteYcategoria(): DataStatusResponse
    {
        if ($_SERVER['REQUEST_METHOD'] != 'GET') {
            return new DataStatusResponse(true, 405, [], 405, "Method Not Allowed", []);
        }

        $json         = file_get_contents('php://input');
        $data         = json_decode($json, true);
        $data['flag'] = 4;

        $response = $this->productoService->getProductsByRestaurantAndCategory($data);

        return new DataStatusResponse(false, 0, [], 200, 'Productos encontrados', $response);
    }
}