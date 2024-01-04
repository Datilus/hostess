<?php

class ProductoService
{
    private ProductoRepository $productoRepository;

    public function __construct()
    {
        $this->productoRepository = new ProductoRepository();
    }

    public function productValidator($data)
    {
        $format = new Format($data);
        $data   = $format->transmute([
            'clave'           => 'numeric|trim',
            'cve_restaurante' => 'numeric|trim',
            'cve_categoria'   => 'numeric|trim',
            'nombre'          => 'trim',
            'slug'            => 'trim',
            'descripcion'     => 'trim',
            'precio'          => 'numeric|trim',
            'json'            => 'trim',
            'estatus'         => 'numeric|trim',
            'cve_usuario'     => 'numeric|trim'
        ]);
        $data   = $format->get_data_response();

        $validator = new Validator($data);
        $validator->validate([
            'clave'           => 'noSpecialCharacters',
            'cve_restaurante' => 'noSpecialCharacters',
            'cve_categoria'   => 'noSpecialCharacters',
            'nombre'          => 'string|noSpecialCharacters|alpha',
            'slug'            => 'string|noSpecialCharacters|alphadash',
            'descripcion'     => 'string|noSpecialCharacters|alphadash',
            'precio'          => 'noSpecialCharacters',
            'json'            => 'string',
            'estatus'         => 'noSpecialCharacters',
            'cve_usuario'     => 'noSpecialCharacters'
        ]);

        return $data;
    }

    public function saveProduct($data): array
    {
        $this->productValidator($data);

        return $this->productoRepository->save($data);
    }

    /**
     * @throws DataStatusResponse
     */
    public function getProductsByFlag($data): array
    {
        $format = new Format($data);
        $data   = $format->transmute([
            'flag' => 'numeric|trim',
            'key'  => 'numeric|trim'
        ]);
        $data   = $format->get_data_response();

        $validator = new Validator($data);
        $validator->validate([
            'flag' => 'noSpecialCharacters',
            'key'  => 'noSpecialCharacters'
        ]);

        return $this->productoRepository->getProductByKey($data);
    }

    /**
     * @throws DataStatusResponse
     */
    public function getProductsByRestaurant($data): array
    {
        $format = new Format($data);
        $data   = $format->transmute([
            'flag'          => 'numeric|trim',
            'keyRestaurant' => 'numeric|trim'
        ]);
        $data   = $format->get_data_response();

        $validator = new Validator($data);
        $validator->validate([
            'flag'          => 'noSpecialCharacters',
            'keyRestaurant' => 'noSpecialCharacters'
        ]);

        return $this->productoRepository->getProductByRestaurant($data);
    }

    /**
     * @throws DataStatusResponse
     */
    public function getProductsByRestaurantAndCategory($data): array
    {
        $format = new Format($data);
        $data   = $format->transmute([
            'flag'            => 'numeric|trim',
            'cve_restaurante' => 'numeric|trim',
            'cve_categoria'   => 'numeric|trim'
        ]);
        $data   = $format->get_data_response();

        $validator = new Validator($data);
        $validator->validate([
            'flag'            => 'noSpecialCharacters',
            'cve_restaurante' => 'noSpecialCharacters',
            'cve_categoria'   => 'noSpecialCharacters'
        ]);

        return $this->productoRepository->getProductByRestaurantAndCategory($data);
    }

}