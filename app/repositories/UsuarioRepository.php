<?php

interface UsuarioRepositoryInterface
{
    public function findAll();

    public function getByKey($data);

    public function getByNumber($data);
}

class UsuarioRepository implements UsuarioRepositoryInterface 
{
    private UsuarioModel $usuarioModel;

    public function __construct()
    {
        $this->usuarioModel = new UsuarioModel();
    }

    public function findAll()
    {
        // return User::all();
    }

    /**
     * @throws DataStatusResponse
     */
    public function getByKey($data): array
    {
        $criteria = $data['key_user'] . '|' . $data['system'];
        return $this->usuarioModel->getFromDataBase(2, $criteria);
    }

    /**
     * @throws DataStatusResponse
     */
    public function getByNumber($data): array
    {
        $criteria = $data['number_user'] . '|' . $data['system'];
        return $this->usuarioModel->getFromDataBase(1, $criteria);
    }

}
