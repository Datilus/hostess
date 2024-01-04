<?php

class UsuarioService
{
    private UsuarioRepository $usuarioRepository;

    public function __construct()
    {
        $this->usuarioRepository = new UsuarioRepository();
    }

    public function getAccess($data)
    {
        $url = "http://192.168.9.110/apis/login/usuario/getByNumber/" . $data['txt_colaborador'] . "/restaurantes";
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

        $response = curl_exec($curl);
        curl_close($curl);

        $response = preg_replace('/[\x{200B}-\x{200D}\x{FEFF}]/u', '', $response);

        return json_decode($response, true);
    }

    /**
     * @throws DataStatusResponse
     */
    public function getByKey($data): array
    {
        $format = new Format($data);
        $data = $format->transmute([
            'key_user'    => 'numeric|trim',
            'system'      => 'uppercase|trim'
        ]);
        $data = $format->get_data_response();

        $validator = new Validator($data);
        $validator->validate([
            'key_user'    => 'noSpecialCharacters',
            'system'      => 'noSpecialCharacters|alpha'
        ]);

        return $this->usuarioRepository->getByKey($data);
    }

    /**
     * @throws DataStatusResponse
     */
    public function getByNumber($data): array
    {
        $format = new Format($data);
        $data = $format->transmute([
            'number_user'    => 'numeric|trim',
            'system'         => 'uppercase|trim'
        ]);
        $data = $format->get_data_response();


        $validator = new Validator($data);
        $validator->validate([
            'number_user'    => 'noSpecialCharacters',
            'system'         => 'noSpecialCharacters|alpha'
        ]);
        return $this->usuarioRepository->getByNumber($data);
    }

}
