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
                                    $jsonRsvnGroup, $jsonRsvnPms, $keyUser, $status)
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

}
