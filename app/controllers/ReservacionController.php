<?php

class Reservacion
{

    private ReservacionService $reservacionService;

    public function __construct()
    {
        $this->reservacionService = new ReservacionService();
    }

    public function agregar(): void
    {
        if ($_SERVER['REQUEST_METHOD'] != 'POST') {
            new DataStatusResponse(true, 405, [], 405, "Method Not Allowed", []);
        }

        $json = file_get_contents('php://input');
        $data = json_decode($json, true);

        $response = $this->reservacionService->saveReservation($data);

        if (!$response['ERROR']) {
            new DataStatusResponse(false, 0, [], 201, 'Reservacion creada', [$response]);
        } else {
            new DataStatusResponse(true, 404, [], 404, 'Error al crear reservacion', []);
        }
    }

    public function clave($parametersURL): void
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
        $data['dateRsvn']      = "0000-00-00";
        $data['timeRsvn']      = "00:00:00";
        $data['keyGroup']      = 0;

        $response = $this->reservacionService->getReservations($data);

        new DataStatusResponse(false, 0, [], 200, 'Reservacion encontrada', $response);
    }

    public function grupo($parametersURL): void
    {
        if ($_SERVER['REQUEST_METHOD'] != 'GET') {
            new DataStatusResponse(true, 405, [], 405, "Method Not Allowed", []);
        }
        if (empty($parametersURL)) {
            new DataStatusResponse(true, 400, [], 400, "Clave on URL not valid", []);
        }

        $data['flag']          = 2;
        $data['key']           = 0;
        $data['keyRestaurant'] = $_GET['cve_restaurante'];
        $data['dateRsvn']      = $_GET['fecha_rsrv'];
        $data['timeRsvn']      = $_GET['hora_rsrv'];
        $data['keyGroup']      = $parametersURL[0];

        $response = $this->reservacionService->getReservations($data);

        new DataStatusResponse(false, 0, [], 200, 'Reservacion encontrada', $response);
    }

}
