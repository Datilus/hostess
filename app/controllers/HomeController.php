<?php
// session_start();

//Heredamos Controlador para poder tener acceso al método modelo y método vista
class Home extends Controller
{
	private $classSessionManager;

	public function __construct()
	{
		$this->classSessionManager = new SessionManager();
	}

	//Todo controlador debe tener un metodo index
	public function index()
	{
		// Validar sesión activa y permiso de acceso
		$this->classSessionManager->is_logged_in( $_SESSION["datos_usuario"]["ID_USUARIO"] );

		$this->view('home/Home');
	}

}


?>