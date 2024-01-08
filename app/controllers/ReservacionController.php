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

}
