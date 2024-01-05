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
                                    $jsonRsvnGroup, $jsonRsvnPms, $status)
    {

    }
}