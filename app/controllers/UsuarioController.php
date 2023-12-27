<?php
//session_start();

//Heredamos Controlador para poder tener acceso al método modelo y método vista
class Usuario extends Controller 
{

	private $sessionManager;
	private $catalogoService;
	private $usuarioService;

	public function __construct()
	{
		$this->sessionManager = new SessionManager();
		$this->catalogoService = new CatalogoService();
		$this->usuarioService = new UsuarioService();
	}


	//Todo controlador debe tener un metodo index
	public function index() 
	{
        echo "Hola mundo";
//		$this->sessionManager->is_logged_in( $_SESSION["datos_usuario"]["ID_USUARIO"] );
//		// $this->sessionManager->CheckPermission( ["permisos" => [4]], 0 );
//
//		$datos['perfil'] = $this->catalogoService->getAllProfiles();
//		$datos['datos_usuario'] = $this->usuarioService->userDataModel();
//
//		$this->view('usuario/Usuario', $datos);
	}


	public function consultarUsuario()
	{
		$this->sessionManager->is_logged_in( $_SESSION["datos_usuario"]["ID_USUARIO"] );
		$this->sessionManager->verify_token( strip_tags($_REQUEST['TOKEN']) );
		
		$this->view('usuario/consultarUsuario');
	}


	public function editar($parametrosURL)
	{
		$this->sessionManager->is_logged_in( $_SESSION["datos_usuario"]["ID_USUARIO"] );
		$this->sessionManager->verify_token( strip_tags($_REQUEST['TOKEN']) );

		$datos['perfil'] = $this->catalogoService->getAllProfiles();

		$data_usuario = [
			'id_usuario' => ( empty($parametrosURL[0]) ) ? 0 : $parametrosURL[0] ,
		];
		$json_data_usuario = $this->usuarioService->getUserById( $data_usuario );

		$datos['datos_usuario'] = json_decode($json_data_usuario['JSON_DATA_USUARIO'], true);
		
		$this->view('usuario/Usuario', $datos);
	}


	public function guardar()
	{
		$this->sessionManager->is_logged_in( $_SESSION["datos_usuario"]["ID_USUARIO"] );
		$this->sessionManager->verify_token( strip_tags($_REQUEST['TOKEN']) );

		$data_usuario = [
			'id_usuario'    => ( empty($_POST['txt_id_usuario']) ) ? 0 : $_POST['txt_id_usuario'] ,
			'id_perfil'     => ( empty($_POST['cmb_perfil']) ) ? 0 : $_POST['cmb_perfil'] ,
			'id_publicador' => ( empty($_POST['txt_id_publicador']) ) ? 0 : $_POST['txt_id_publicador'] ,
			'usuario'       => $_POST['txt_usuario'],
			'password'      => $_POST['txt_password']
		];

		if ( strip_tags($_REQUEST['ACCION']) == 'index' ) {
			$this->usuarioService->createUser($data_usuario);
		}elseif ( strip_tags($_REQUEST['ACCION'])  == 'editar' ){
			$this->usuarioService->UpdateUser($data_usuario);
		}else {
            throw new DataStatusResponse(true, 0, "Accion no permitida.", 203, ['status_msg' => 'warning']);
        }
	}


	public function borrar() 
	{
		$this->sessionManager->is_logged_in( $_SESSION["datos_usuario"]["ID_USUARIO"] );
		$this->sessionManager->verify_token( strip_tags($_REQUEST['TOKEN']) );

		$data_usuario = [
			'id_usuario' => ( empty($_POST['id_usuario']) ) ? 0 : $_POST['id_usuario'] ,
		];

		$this->usuarioService->deleteUser($data_usuario);

	}


	public function data_table_list()
	{
		$requestData = [
			"row"    => $_POST['start'],
			"rows"   => $_POST['length'],
			"search" => $_POST['search']['value']
		];
		$this->usuarioService->getDataTableList($requestData);
	}

}

?>