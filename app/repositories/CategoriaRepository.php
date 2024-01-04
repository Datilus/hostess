<?php

interface CategoriaRepositoryInterface
{
    public function save($data);

    public function getCategory($data);
}

class CategoriaRepository implements CategoriaRepositoryInterface
{

    private CategoriaModel $categoriaModel;

    public function __construct()
    {
        $this->categoriaModel = new CategoriaModel();
    }

    public function save($data): array
    {
        $key           = $data['clave'];
        $keyRestaurant = $data['cve_restaurante'];
        $category      = $data['categoria'];
        $name          = $data['nombre'];
        $status        = $data['estatus'];
        $keyUser       = $data['cve_usuario'];

        return $this->categoriaModel->saveCategory(1, $key, $keyRestaurant, $category, $name, $status, $keyUser);
    }

    /**
     * @throws DataStatusResponse
     */
    public function getCategory($data): array
    {
        return $this->categoriaModel->getCategories($data['flag'], $data['key'], $data['keyRestaurant']);
    }
}