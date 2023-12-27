<?php

interface PublicadorRepositoryInterface
{
    public function findAll();

    public function find($id);

    public function create(array $data);

    public function update($id, array $data);

    public function delete($id);
}

class PublicadorRepository implements PublicadorRepositoryInterface 
{
    private $usuarioModel;

    public function __construct()
    {
        $this->usuarioModel = new PublicadorModel();
    }

    public function findAll()
    {
        // return User::all();
    }

    public function find($id)
    {
        // return User::find($id);
    }

    public function create(array $data)
    {
        // return User::create($data);
    }

    public function update($id, array $data)
    {
        // $user = User::find($id);
        // $user->update($data);
        // return $user;
    }

    public function delete($id)
    {
        // $user = User::find($id);
        // $user->delete();
    }


    public function findByConcatString($ban, $concat_string)
    {
        return $this->usuarioModel
        ->set_ban($ban)
        ->DataToGetByConcatString($concat_string)
        ->getFromDataBase();
    }


    public function findAllDataTableListCatalogo($ban, $id_congregacion, $data_config_table)
    {
        return $this->usuarioModel
        ->set_ban($ban)
        ->set_id_congregacion($id_congregacion)
        ->DataToGetDataList($data_config_table)
        ->getDataTableList();
    }

}