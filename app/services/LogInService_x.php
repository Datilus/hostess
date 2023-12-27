<?php

class LoginService
{
    private $usuarioRepository;

    public function __construct()
    {
        $this->usuarioRepository = new UsuarioRepository();
    }

    public function getAllUsers()
    {
        // return $this->userRepository->all();
    }

    public function getUserById($id)
    {
        // return $this->userRepository->find($id);
        return $this->usuarioRepository->findByConcatString(2, $id);
    }

    public function createUser(array $data)
    {
        // return $this->userRepository->create($data);
    }

    public function updateUser($id, array $data)
    {
        // return $this->userRepository->update($id, $data);
    }

    public function deleteUser($id)
    {
        // $this->userRepository->delete($id);
    }

    public function authenticateUser($usuario, $password)
    {
        $user = $this->userRepository->getUserByEmail($email);
    }
}