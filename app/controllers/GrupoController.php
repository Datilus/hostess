<?php

//Heredamos Controlador para poder tener acceso al método modelo y método vista
class Grupo extends Controller {

	private $controlador = "Grupo";

	// private $modelCatalogo;

	private $classGrupo,
			$classSessionManager;

	public function __construct() {

		$this->classGrupo = new _Grupo();
		$this->classSessionManager = new SessionManager();

		// $this->modelCatalogo = $this->model('CatalogoModel');
	}


	//Todo controlador debe tener un metodo index
	public function index() 
	{
		// Validar sesión activa y permiso de acceso
		$this->classSessionManager->is_logged_in( $_SESSION["datos_usuario"]["ID_USUARIO"] );

		$this->classSessionManager->CheckPermission( ["permisos" => [13]], 0 );

		$this->view('grupo/grupo', $datos);
	}


	public function consultarGrupo()
	{
		$this->classSessionManager->is_logged_in( $_SESSION["datos_usuario"]["ID_USUARIO"] );

		$this->classSessionManager->verify_token( strip_tags($_REQUEST['TOKEN']) );
		
		$this->view('grupo/consultarGrupo');
	}


	public function editar($parametrosURL)
	{
		$this->classSessionManager->is_logged_in( $_SESSION["datos_usuario"]["ID_USUARIO"] );

		$this->classSessionManager->verify_token( strip_tags($_REQUEST['TOKEN']) );

		$this->classSessionManager->CheckPermission( ["permisos" => [14]], 0 );

		$json_data_grupo =  $this->classGrupo->obtener_grupo_por_id( $parametrosURL[0] );

		$datos['datos_grupo'] = json_decode($json_data_grupo['JSON_DATA_GRUPO'], true);
		
		$this->view('grupo/Grupo', $datos);
	}


	public function guardar() 
	{
		$this->classSessionManager->is_logged_in( $_SESSION["datos_usuario"]["ID_USUARIO"] );

		$this->classSessionManager->verify_token( strip_tags($_REQUEST['TOKEN']) );

		$this->classSessionManager->CheckPermission( ["permisos" => [13,14]], 1 );

		$data_grupo = [
			'id_grupo'        => $_POST['txt_id_grupo'],
			'id_congregacion' => ( empty($_SESSION["datos_usuario"]["ID_CONGREGACION"]) ) ? 0 : $_SESSION["datos_usuario"]["ID_CONGREGACION"],
			'grupo'           => $_POST['txt_grupo'],
			'id_responsable'  => $_POST['txt_id_responsable'],
			'id_auxiliar'     => $_POST['txt_id_auxiliar']
		];

		$this->classGrupo->guardar($data_grupo);

	}


	public function borrar() 
	{
		$this->classSessionManager->is_logged_in( $_SESSION["datos_usuario"]["ID_USUARIO"] );

		$this->classSessionManager->verify_token( strip_tags($_REQUEST['TOKEN']) );

		$this->classSessionManager->CheckPermission( ["permisos" => [15]], 1 );

		$data_grupo = [
			'id_grupo' => $_POST['id_grupo'],
		];

		$this->classGrupo->borrar($data_grupo);

	}


	public function data_table_list()
	{
		$data =  array (
			"ban"    => 1,
			"row"    => $_POST['start'],
			"rows"   => $_POST['length'],
			'id_congregacion' => ( empty($_SESSION["datos_usuario"]["ID_CONGREGACION"]) ) ? 0 : $_SESSION["datos_usuario"]["ID_CONGREGACION"],
			"search" => $_POST['search']['value']
		);
		$json_data = $this->classGrupo->data_table_list( $data );

		$data = json_decode($json_data, true);


		// --- Pintamos los datos en la datatable
		foreach ($data['data_list'] as $value) {

			// Acciones
			$acciones = "
			<div class='margin'>
				<div class='btn-group'>
					<button type='button' class='btn btn-default btn-xs pt-0 pb-0' data-toggle='dropdown' aria-expanded='true' style='font-size: 9px;'>
						<span class='fa fa-ellipsis-h'></span>
					</button>
					<div class='dropdown-menu dropdown-menu-right' role='menu'>";

			// if ( in_array(8, $_SESSION["permisos"]) === true ){
			$acciones .= "
						<small>
							<a class='dropdown-item text-muted nav-link' href='#' name='editar' data-id_grupo='". intval($value['id']) ."'>Editar</a>
						</small>
			";
			// }

			// if ( in_array(9, $_SESSION["permisos"]) === true ){
			$acciones .= "
						<small>
							<a class='dropdown-item text-muted' href='#' name='borrar' data-id_grupo='". intval($value['id']) ."'>Borrar</a>
						</small>
			";
			// }

			$acciones .= "
					</div>
				</div>
			</div>
			";

			$subdatos = array();
			$subdatos[] = $value['id'];
			$subdatos[] = $value['nombre_grupo'];
			$subdatos[] = $value['responsable'];
			$subdatos[] = $value['auxiliar'];
			$subdatos[] = $acciones;
			$datos[] = $subdatos;
		}

		$json_data = array(
			"draw" => $_POST['draw'],
			"recordsTotal" => $data['total_data'],
			"recordsFiltered" => $data['total_filter'],
			"data" => $datos
		);
		
		echo json_encode($json_data);
	}

}

?>