<?php

class CategoriaService
{
    private CategoriaRepository $categoriaRepository;

    public function __construct()
    {
        $this->categoriaRepository = new CategoriaRepository();
    }

    public function saveCategory($data): array
    {
        $format = new Format($data);
        $data   = $format->transmute([
            'clave'           => 'numeric|trim',
            'cve_restaurante' => 'numeric|trim',
            'categoria'       => 'trim',
            'nombre'          => 'trim',
            'estatus'         => 'numeric|trim',
            'cve_usuario'     => 'numeric|trim'
        ]);
        $data   = $format->get_data_response();

        $validator = new Validator($data);
        $validator->validate([
            'clave'           => 'noSpecialCharacters',
            'cve_restaurante' => 'noSpecialCharacters',
            'categoria'       => 'string|noSpecialCharacters|alpha',
            'nombre'          => 'string|noSpecialCharacters|alphadash',
            'estatus'         => 'noSpecialCharacters',
            'cve_usuario'     => 'noSpecialCharacters'
        ]);

        return $this->categoriaRepository->save($data);
    }

    /**
     * @throws DataStatusResponse
     */
    public function getCategories($data): array
    {
        $format = new Format($data);
        $data   = $format->transmute([
            'flag'          => 'numeric|trim',
            'key'           => 'numeric|trim',
            'keyRestaurant' => 'numeric|trim'
        ]);
        $data   = $format->get_data_response();

        $validator = new Validator($data);
        $validator->validate([
            'flag'          => 'noSpecialCharacters',
            'key'           => 'noSpecialCharacters',
            'keyRestaurant' => 'noSpecialCharacters'
        ]);

        return $this->categoriaRepository->getCategory($data);
    }
}