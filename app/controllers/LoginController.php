<?php
// session_start();

//Heredamos Controlador para poder tener acceso al método modelo y método vista
class Login extends Controller
{
	private $sessionManager;

	private $usuarioService;

	public function __construct()
	{
		$this->sessionManager = new SessionManager();
		$this->usuarioService = new UsuarioService();
	}


	//Todo controlador debe tener un metodo index
	public function index()
	{
		$this->view('login/Login');
	}


	public function logIn()
	{
		$requestData = [
			"username" => $_POST['usuario'],
			"password" => $_POST['password']
		];

		$this->usuarioService->authenticateUser($requestData);
	}


	public function cerrar_sesion()
	{
		$this->sessionManager->close_session();
	}


}

?>