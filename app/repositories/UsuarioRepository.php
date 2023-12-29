<?php

interface UsuarioRepositoryInterface
{
    public function findAll();

    public function getByKey($data);

    public function create(array $data);

    public function update($id, array $data);

    public function delete($id);
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

    public function findUserExist($username)
    {
        return $this->usuarioModel->getUserExistByUser($username);
    }

    public function create(array $data): array
    {
        return $this->usuarioModel
        ->set_ban('CREUSR')
        ->set_id_usuario($data['id_usuario'])
        ->set_id_perfil($data['id_perfil'])
        ->set_id_publicador($data['id_publicador'])
        ->set_usuario($data['usuario'])
        ->set_password($data['password'])
        ->DataToCreate()
        ->create();

    }

    public function update($id, array $data)
    {
        // $user = User::find($id);
        // $user->update($data);
        // return $user;
    }

    public function delete($id)
    {
        return $this->usuarioModel
        ->set_ban('DELUSR')
        ->set_id_usuario($id)
        ->DataToCreate()
        ->create();
    }


    public function findByConcatString($ban, $concat_string)
    {
        return $this->usuarioModel
        ->set_ban($ban)
        ->DataToGetByConcatString($concat_string)
        ->getFromDataBase();
    }


    public function findItemsMenuByProfile($ban, $profile)
    {
        return $this->usuarioModel
        ->set_ban($ban)
        ->DataToGetByConcatString($profile)
        ->getItemsMenu();
    }


    public function findByPermissionsByProfile($ban, $profile)
    {
        return $this->usuarioModel
        ->set_ban($ban)
        ->DataToGetByConcatString($profile)
        ->getPermissions();
    }


    public function getAllDataTableList($ban, $data_config_table)
    {
        return $this->usuarioModel
        ->set_ban($ban)
        ->DataToGetDataList($data_config_table)
        ->getDataTableList();
    }

}
