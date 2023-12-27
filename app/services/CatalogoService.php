<?php

class CatalogoService
{
    private $catalogoRepository;

    public function __construct()
    {
        $this->catalogoRepository = new CatalogoRepository();
    }

    public function getAllProfiles()
    {
        return $this->catalogoRepository->findByConcatString('GETPER');
    }

}