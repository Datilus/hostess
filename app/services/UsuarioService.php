<?php

class UsuarioService
{
    private UsuarioRepository $usuarioRepository;

    public function __construct()
    {
        $this->usuarioRepository = new UsuarioRepository();
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
