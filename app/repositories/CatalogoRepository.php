<?php

interface CatalogoRepositoryInterface
{
    public function findByConcatString($id);
}

class CatalogoRepository implements CatalogoRepositoryInterface 
{
    // private $usuario;
    private $catalogoModel;

    public function __construct()
    {
        // $this->usuario = new Usuario_();
        $this->catalogoModel = new CatalogoModel();
    }


    public function findByConcatString($ban)
    {
        return $this->catalogoModel
        ->set_ban($ban)
        ->DataToGetByConcatString()
        ->getFromDataBase();
    }

}