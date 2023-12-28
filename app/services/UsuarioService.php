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
            'key_usuario'    => 'numeric|trim'
        ]);
        $data = $format->get_data_response();


        $validator = new Validator($data);
        $validator->validate([
            'key_usuario'    => 'noSpecialCharacters'
        ]);

        return $this->usuarioRepository->getByKey($data['key_usuario']);
    }

    /**
     * @throws DataStatusResponse
     */
    public function getById($data): array
    {
        $format = new Format($data);
        $data = $format->transmute([
            'id_usuario'    => 'numeric|trim'
        ]);
        $data = $format->get_data_response();


        $validator = new Validator($data);
        $validator->validate([
            'id_usuario'    => 'noSpecialCharacters'
        ]);
        return $this->usuarioRepository->getById($data['id_usuario']);
    }

}
