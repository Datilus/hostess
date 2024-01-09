<?php

class ReservacionService
{

    private ReservacionRepository $reservacionRepository;

    public function __construct()
    {
        $this->reservacionRepository = new ReservacionRepository();
    }

    public function saveReservation($data): array
    {
        $format = new Format($data);
        $data   = $format->transmute([
            'cve_restaurante'          => 'numeric|trim',
            'hora_rsrv'                => 'trim',
            'fecha_rsrv'               => 'trim',
            'nombre_titular'           => 'trim|uppercase',
            'apellido_titular'         => 'trim|uppercase',
            'fecha_nacimiento_titular' => 'trim',
            'movil_titular'            => 'trim',
            'email_titular'            => 'trim|lowercase',
            'json_acompanantes'        => 'trim',
            'cve_rsrv_grps'            => 'numeric|trim',
            'json_rsrv_grps'           => 'trim',
            'json_rsrv_pms'            => 'trim',
            'estatus'                  => 'numeric|trim',
            'cve_usuario'              => 'numeric|trim'
        ]);
        $data   = $format->get_data_response();

        $validator = new Validator($data);
        $validator->validate([
            'cve_restaurante'          => 'noSpecialCharacters',
            'hora_rsrv'                => 'string',
            'fecha_rsrv'               => 'noSpecialCharacters|string',
            'nombre_titular'           => 'string|noSpecialCharacters',
            'apellido_titular'         => 'string|noSpecialCharacters',
            'fecha_nacimiento_titular' => 'string|noSpecialCharacters',
            'movil_titular'            => 'string|noSpecialCharacters',
            'email_titular'            => 'email|string|noSpecialCharacters',
            'json_acompanantes'        => 'string|noSpecialCharacters',
            'cve_rsrv_grps'            => 'noSpecialCharacters',
            'json_rsrv_grps'           => 'string|noSpecialCharacters',
            'json_rsrv_pms'            => 'string|noSpecialCharacters',
            'estatus'                  => 'noSpecialCharacters',
            'cve_usuario'              => 'noSpecialCharacters'
        ]);

        return $this->reservacionRepository->saveReservation($data);
    }

    public function getReservations($data): array
    {
        $format = new Format($data);
        $data   = $format->transmute([
            'flag'          => 'numeric|trim',
            'key'           => 'numeric|trim',
            'keyRestaurant' => 'numeric|trim',
            'dateRsvn'      => 'trim',
            'timeRsvn'      => 'trim',
            'keyGroup'      => 'numeric|trim'
        ]);
        $data = $format->get_data_response();

        $validator = new Validator($data);
        $validator->validate([
            'flag'          => 'noSpecialCharacters',
            'key'           => 'noSpecialCharacters',
            'keyRestaurant' => 'noSpecialCharacters',
            'dateRsvn'      => 'string',
            'timeRsvn'      => 'string',
            'keyGroup'      => 'noSpecialCharacters'
        ]);

        return $this->reservacionRepository->getReservation($data);
    }


}