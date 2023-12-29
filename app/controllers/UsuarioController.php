<?php
//session_start();

//Heredamos Controlador para poder tener acceso al método modelo y método vista
class Usuario {

	private UsuarioService $usuarioService;

	public function __construct()
	{
		$this->usuarioService = new UsuarioService();
	}


	//Todo controlador debe tener un metodo index
	public function index() 
	{
        return new DataStatusResponse(true, 404, [],404, "Not Found", []);
	}

    /**
     * @throws DataStatusResponse
     */
    public function getByKey($parametersURL): DataStatusResponse
    {
        if ($_SERVER['REQUEST_METHOD'] != 'GET') {
            return new DataStatusResponse(true, 405, [],405, "Method Not Allowed", []);
        }
        $data['key_user'] = $parametersURL[0];
        $data['system'] = $parametersURL[1];
        $response = $this->usuarioService->getByKey($data);

        return new DataStatusResponse(false, 0, [],200, "Usuario encontrado", [$response]);
    }

    /**
     * @throws DataStatusResponse
     */
    public function getByNumber($parametersURL): DataStatusResponse
    {
        if ($_SERVER['REQUEST_METHOD'] != 'GET') {
            return new DataStatusResponse(true, 405, [],405, "Method Not Allowed", []);
        }
        $data['number_user'] = $parametersURL[0];
        $data['system'] = $parametersURL[1];
        $response = $this->usuarioService->getByNumber($data);

        return new DataStatusResponse(false, 0, [], 200, 'Usuario encontrado', [$response]);
    }

}
