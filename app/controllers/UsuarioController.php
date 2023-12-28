<?php
//session_start();

//Heredamos Controlador para poder tener acceso al método modelo y método vista
class Usuario extends Controller 
{

	private UsuarioService $usuarioService;

	public function __construct()
	{
		$this->usuarioService = new UsuarioService();
	}


	//Todo controlador debe tener un metodo index
	public function index() 
	{
        echo "Hola mundo";
	}

    public function getByKey($parametrosURL): DataStatusResponse
    {
        $data['key_usuario'] = $parametrosURL[0];
        $data['sistema'] = $parametrosURL[1];
        $response = $this->usuarioService->getByKey($data);

        return new DataStatusResponse(false, 0, [],200, "Usuario encontrado", ['data' => $response]);
    }

    public function getById($parametrosURL): DataStatusResponse
    {
        $data['id_usuario'] = $parametrosURL[0];
        $response = $this->usuarioService->getById($data);

        return new DataStatusResponse(false, 0, [], 200, 'Usuario encontrado', ['data' => $response]);
    }

}
