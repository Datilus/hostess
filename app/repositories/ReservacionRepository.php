<?php

interface ReservacionRepositoryInterface
{
    public function saveReservation($data);

    public function getReservation($data);
}

class ReservacionRepository implements ReservacionRepositoryInterface
{

    private ReservacionModel $reservacionModel;

    public function __construct()
    {
        $this->reservacionModel = new ReservacionModel();
    }

    public function saveReservation($data): array
    {
        $keyRestaurant  = $data['cve_restaurante'];
        $timeRsvn       = $data['hora_rsrv'];
        $dateRsvn       = $data['fecha_rsrv'];
        $nameHolder     = $data['nombre_titular'];
        $surnameHolder  = $data['apellido_titular'];
        $birthdayHolder = $data['fecha_nacimiento_titular'];
        $phoneHolder    = $data['movil_titular'];
        $emailHolder    = $data['email_titular'];
        $jsonGuests     = $data['json_acompanantes'];
        $keyRsvnGroup   = $data['cve_rsrv_grps'];
        $jsonRsvnGroup  = $data['json_rsrv_grps'];
        $jsonRsvnPms    = $data['json_rsrv_pms'];
        $status         = $data['estatus'];
        $keyUser        = $data['cve_usuario'];

        return $this->reservacionModel->saveReservation(1, $keyRestaurant, $timeRsvn, $dateRsvn, $nameHolder,
            $surnameHolder, $birthdayHolder, $phoneHolder, $emailHolder, $jsonGuests, $keyRsvnGroup, $jsonRsvnGroup,
            $jsonRsvnPms, $keyUser, $status);
    }

    public function getReservation($data)
    {
        // TODO: Implement getReservation() method.
    }
}