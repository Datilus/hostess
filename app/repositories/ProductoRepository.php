<?php

interface ProductoRepositoryInterface
{
    public function save($data);
}

class ProductoRepository implements ProductoRepositoryInterface
{
    private ProductoModel $productoModel;

    public function __construct()
    {
        $this->productoModel = new ProductoModel();
    }

    public function save($data): array
    {
        $key           = $data['clave'];
        $cveRestaurant = $data['cve_restaurante'];
        $cveCategory   = $data['cve_categoria'];
        $name          = $data['nombre'];
        $slug          = $data['slug'];
        $description   = $data['descripcion'];
        $price         = $data['precio'];
        $jsonOp        = $data['json'];
        $status        = $data['estatus'];
        $cveUser       = $data['cve_usuario'];

        return $this->productoModel->saveProduct(1, $key, $cveRestaurant, $cveCategory, $name, $slug, $description,
            $price, $jsonOp, $status, $cveUser);
    }

    /**
     * @throws DataStatusResponse
     */
    public function getProductByKey($data): array
    {
        return $this->productoModel->getProducts($data['flag'], $data['key'], 0, 0);
    }

    /**
     * @throws DataStatusResponse
     */
    public function getProductByRestaurant($data): array
    {
        return $this->productoModel->getProducts($data['flag'], 0, $data['keyRestaurant'], 0);
    }

    /**
     * @throws DataStatusResponse
     */
    public function getProductByRestaurantAndCategory($data): array
    {
        return $this->productoModel->getProducts($data['flag'], 0, $data['cve_restaurante'], $data['cve_categoria']);
    }

}