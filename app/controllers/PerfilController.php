<?php
//session_start();

//Heredamos Controlador para poder tener acceso al método modelo y método vista
class Perfil extends Controller {

	private $controlador = "Perfil";

	private $modelCatalogo;

	private $classPerfil,
			$classSessionManager;
	
    // private $modeloPerfil;

	public function __construct() {

		$this->classPerfil = new _Perfil();

		$this->classSessionManager = new SessionManager();

		$this->modelCatalogo = $this->model('CatalogoModel');

		// $this->modeloPerfil = $this->modelo('PerfilModelo');

	}


	//Todo controlador debe tener un metodo index
	public function index() 
	{
		// Validar sesión activa y permiso de acceso
		$this->classSessionManager->is_logged_in( $_SESSION["datos_usuario"]["ID_USUARIO"] );

		$this->classSessionManager->CheckPermission( ["permisos" => [1]], 0 );

		// $datos['menu_permisos'] = $this->modelCatalogo->obtener_menu_y_permisos(['ban'=> 'GETCOL', 'opciones' => ['tipo'=> "L"]]);

		$this->view('perfil/Perfil', $datos);
	}


}

?>