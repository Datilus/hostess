<?php

class ReservacionModel
{

    public ConexionBD $conexionBD;

    public function __construct()
    {
        $this->conexionBD = ConexionBD::obtenerInstancia();
    }

    public function saveReservation($flag, $keyRestaurant, $timeRsvn, $dateRsvn, $nameHolder, $surnameHolder,
                                    $birthdayHolder, $phoneHolder, $emailHolder, $jsonGuests, $keyRsvnGroup,
                                    $jsonRsvnGroup, $jsonRsvnPms, $keyUser, $status): array
    {
        $query = "CALL GUARDAR_RESERVACION(
            '$flag', 
            '$keyRestaurant', 
            '$timeRsvn', 
            '$dateRsvn', 
            '$nameHolder', 
            '$surnameHolder',
            '$birthdayHolder', 
            '$phoneHolder', 
            '$emailHolder', 
            '$jsonGuests', 
            '$keyRsvnGroup',
            '$jsonRsvnGroup', 
            '$jsonRsvnPms',
            '$keyUser', 
            '$status'
        )";

        $inquiry  = $this->conexionBD->query($query);
        $response = $this->conexionBD->consulta_assoc($inquiry);

        $this->conexionBD->next_result();

        return $response;
    }

    public function getReservation($flag, $key, $keyRestaurant, $dateRsvn, $timeRsvn, $keyGroup): array
    {
        $query = "CALL OBTEN_RESERVACIONES(
            '$flag', 
            '$key', 
            '$keyRestaurant', 
            '$dateRsvn', 
            '$timeRsvn', 
            '$keyGroup'
        )";

        $inquiry  = $this->conexionBD->query($query);
        $response = $this->conexionBD->consulta_array($inquiry);

        $this->conexionBD->next_result();

        if (empty($response)) {
            new DataStatusResponse(true, 404, [], 404, "No data founded", []);
        }

        return $response;
    }

}
