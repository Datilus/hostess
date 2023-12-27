<?php
//session_start();

//Heredamos Controlador para poder tener acceso al método modelo y método vista
class Publicador extends Controller {

	private $controlador = "Publicador";

	private $modelPublicador,
			$modelCatalogo;

	private $sessionManagerService;
	private $permissionService;

	private $publicadorService;
	
    // private $modeloUsuario;

	public function __construct() {

		// $this->classPublicador = new _Publicador();
		$this->sessionManagerService = new SessionManagerService();
		$this->permissionService = new PermissionService();

		$this->modelPublicador = $this->model('PublicadorModel');
        $this->modelCatalogo = $this->model('CatalogoModel');

		$this->publicadorService = new PublicadorService();
	}


	//Todo controlador debe tener un metodo index
	public function index() 
	{
		// Validar sesión activa y permiso de acceso
		// $this->sessionManagerService->is_logged_in( $_SESSION["datos_usuario"]["ID_USUARIO"] );
		$this->sessionManagerService->ValidateSessionSecurity( $_SESSION["datos_usuario"]["ID_USUARIO"], $_SESSION["token"] );
		$this->permissionService->CheckPermission( ["permisos" => [10]], 0 );

		$datos['tipo'] = [
			"PUNOBA" => "PUBLICADOR NO BAUTIZADO",
			"PUBBAU" => "PUBLICADOR BAUTIZADO",
			"SIEMIN" => "SIERVO MINISTERIAL",
			"ANCIAN" => "ANCIANO"
		];

		$datos['genero'] = [
			"H" => "HOMBRE",
			"M" => "MUJER"
		];

		$datos['estatus'] = [
			"PUBACT" => "ACTIVO",
			"PUBBAJ" => "BAJA",
			"SENSUR" => "SENSURADO",
			"EXPULS" => "EXPULSADO",
			"INACTI" => "INACTIVO"
		];

		$datos['colonias'] = $this->modelCatalogo->obtenerColonias(['ban'=> 'GETCOL', 'opciones' => ['tipo'=> "L"]]);

		$datos['grupos'] = $this->modelCatalogo->obtenerCatalogo(['ban' => 'GETGRP', 'search' => $_SESSION["datos_usuario"]["ID_CONGREGACION"], 'opciones' => ['tipo'=> "L"]]);

		$this->view('publicador/Publicador', $datos);
	}


	public function consultarPublicador()
	{
		// $this->sessionManagerService->is_logged_in( $_SESSION["datos_usuario"]["ID_USUARIO"] );
		// $this->sessionManagerService->verify_token( strip_tags($_REQUEST['TOKEN']) );
		$this->sessionManagerService->ValidateSessionSecurity( $_SESSION["datos_usuario"]["ID_USUARIO"], $_SESSION["token"] );
		
		$this->view('publicador/consultarPublicador');
	}


	public function editar($parametrosURL)
	{
		// $this->sessionManagerService->is_logged_in( $_SESSION["datos_usuario"]["ID_USUARIO"] );
		// $this->sessionManagerService->verify_token( strip_tags($_REQUEST['TOKEN']) );
		$this->sessionManagerService->ValidateSessionSecurity( $_SESSION["datos_usuario"]["ID_USUARIO"], $_SESSION["token"] );

		$this->sessionManagerService->CheckPermission( ["permisos" => [11]], 0 );

		$datos['tipo'] = [
			"PUNOBA" => "PUBLICADOR NO BAUTIZADO",
			"PUBBAU" => "PUBLICADOR BAUTIZADO",
			"SIEMIN" => "SIERVO MINISTERIAL",
			"ANCIAN" => "ANCIANO"
		];

		$datos['genero'] = [
			"H" => "HOMBRE",
			"M" => "MUJER"
		];

		$datos['estatus'] = [
			"PUBACT" => "ACTIVO",
			"PUBBAJ" => "BAJA",
			"SENSUR" => "SENSURADO",
			"EXPULS" => "EXPULSADO",
			"INACTI" => "INACTIVO"
		];

		$datos['colonias'] = $this->modelCatalogo->obtenerColonias(['ban'=> 'GETCOL', 'opciones' => ['tipo'=> "L"]]);

		$datos['grupos'] = $this->modelCatalogo->obtenerCatalogo(['ban' => 'GETGRP', 'search' => $_SESSION["datos_usuario"]["ID_CONGREGACION"], 'opciones' => ['tipo'=> "L"]]);

		$json_data_publicador =  $this->classPublicador->obtener_publicador_por_id( $parametrosURL[0] );

		$datos['datos_publicador'] = json_decode($json_data_publicador['JSON_DATA_PUBLICADOR'], true);
		
		$this->view('publicador/Publicador', $datos);
	}


	public function guardar() 
	{
		// $this->sessionManagerService->is_logged_in( $_SESSION["datos_usuario"]["ID_USUARIO"] );
		// $this->sessionManagerService->verify_token( strip_tags($_REQUEST['TOKEN']) );
		$this->sessionManagerService->ValidateSessionSecurity( $_SESSION["datos_usuario"]["ID_USUARIO"], $_SESSION["token"] );

		$this->sessionManagerService->CheckPermission( ["permisos" => [10,11]], 1 );

		$data_publicador = [
			'id_publicador'    => (int) $_POST['txt_id_publicador'],
			'id_congregacion'  => (int) ( empty($_SESSION["datos_usuario"]["ID_CONGREGACION"]) ) ? 0 : $_SESSION["datos_usuario"]["ID_CONGREGACION"],
			'codigo_tipo'      => (string) $_POST['cmb_tipo'],
			'fecha_bautismo'   => (string) $_POST['txt_fecha_bautismo'],
			'nombre'           => (string) $_POST['txt_nombre'],
			'apellido_paterno' => (string) $_POST['txt_apellido_paterno'],
			'apellido_materno' => (string) $_POST['txt_apellido_materno'],
			'genero'           => (string) $_POST['cmb_genero'],
			'fecha_nacimiento' => (string) $_POST['txt_fecha_nacimiento'],
			'calle'            => (string) $_POST['txt_calle_casa'],
			'numero_casa'      => (string) $_POST['txt_numero_domicilio'],
			'codigo_colonia'   => (string) $_POST['cmb_colonia'],
			'telefono'         => (string) $_POST['txt_telefono'],
			'movil'            => (string) $_POST['txt_movil'],
			'id_grupo'         => (int) $_POST['cmb_grupo'],
			'json_contactos'   => (string) $_POST["json_contactos_emergencia"],
			'estatus'          => (string) $_POST['cmb_estatus']
		];

		// $this->publicadorService->DataSavePublicador( $data_publicador );

		$response = $this->modelPublicador->guardar(
			$this->publicadorService->DataSavePublicador( $data_publicador )
		);

        $status_msg = ( $response['ERROR'] ) ? 'error' : 'success' ;
        throw new DataStatusResponse( $response['ERROR'], 0, 'Publicador guardado.', 201, ['status_msg' => $status_msg] );
	}


	public function borrar() 
	{
		// $this->sessionManagerService->is_logged_in( $_SESSION["datos_usuario"]["ID_USUARIO"] );
		// $this->sessionManagerService->verify_token( strip_tags($_REQUEST['TOKEN']) );
		$this->sessionManagerService->ValidateSessionSecurity( $_SESSION["datos_usuario"]["ID_USUARIO"], $_SESSION["token"] );

		$this->sessionManagerService->CheckPermission( ["permisos" => [12]], 1 );

		$data_publicador = [
			'id_publicador' => $_POST['id_publicador'],
		];

		$this->classPublicador->borrar($data_publicador);

	}


	public function data_table_list()
	{
		$data =  array (
			"ban"             => 1,
			"row"             => $_POST['start'],
			"rows"            => $_POST['length'],
			'id_congregacion' => ( empty($_SESSION["datos_usuario"]["ID_CONGREGACION"]) ) ? 0 : $_SESSION["datos_usuario"]["ID_CONGREGACION"],
			"search"          => $_POST['search']['value']
		);
		// $json_data = $this->classPublicador->data_table_list( $data );
		$data_response = $this->modelPublicador->data_list($data);

		$data = json_decode($data_response['JSON_DATA_LIST'], true);
		
		// --- Pintamos los datos en la datatable
		foreach ($data['data_list'] as $value) {

			$estatus_color = match($value['estatus']){
				'PUBACT' => "success",
				'EXPULS' => "danger",
				'SENSUR' => "warning",
				'INACTI' => "default"
			};
			$badge_estatus = "<small class='badge bg-{$estatus_color}'>{$value['estatus_descripcion']}</small>";

			$telefono = ( empty($value['telefono']) ) ? "" : "Tel: " . $value['telefono'] ;
			$separador = ( !empty($value['movil']) && !empty($value['telefono']) ) ? " , " : "" ;
			$movil = ( empty($value['movil']) ) ? "" : "Cel: " . $value['movil'] ;

			// Acciones
			$acciones = "
			<div class='margin'>
				<div class='btn-group'>
					<button type='button' class='btn btn-default btn-xs pt-0 pb-0' data-toggle='dropdown' aria-expanded='true' style='font-size: 9px;'>
						<span class='fa fa-ellipsis-h'></span>
					</button>
					<div class='dropdown-menu dropdown-menu-right' role='menu'>";

			$acciones .= "
						<small>
							<a class='dropdown-item text-muted nav-link' href='#' name='editar' data-id_publicador='". intval($value['id']) ."'>Editar</a>
						</small>
			";

			$acciones .= "
						<small>
							<a class='dropdown-item text-muted' href='#' name='borrar' data-id_publicador='". intval($value['id']) ."'>Borrar</a>
						</small>
			";

			$acciones .= "
					</div>
				</div>
			</div>
			";

			$subdatos = array();
			$subdatos[] = "<a href='#' name='info' data-id_publicador='{$value['id']}' style='font-weight: bold;'>{$value['id']}</a>";
			$subdatos[] = $value['publicador'];
			$subdatos[] = $value['calle_casa'] . " " . $value['numero_casa'] . ", " . $value['colonia'];
			$subdatos[] = $telefono . $separador . $movil;
			$subdatos[] = $value['tipo'];
			$subdatos[] = $value['grupo'];
			$subdatos[] = $badge_estatus;
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


	public function data_table_list_catalogo()
	{
		$data =  array (
			"ban"    => 2,
			"row"    => $_POST['start'],
			"rows"   => $_POST['length'],
			"search" => $_POST['search']['value']
		);
		$json_data = $this->classPublicador->data_table_list( $data );

		$data = json_decode($json_data, true);
		
		// --- Pintamos los datos en la datatable
		foreach ($data['data_list'] as $value) {

			$subdatos = array();
			$subdatos[] = $value['id'];
			$subdatos[] = $value['publicador'];
			$subdatos[] = "<i class='fas fa-plus-circle add' style='font-size:12px; cursor: pointer;' ></i>";
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


	public function info_publicador()
	{
		// $this->sessionManagerService->is_logged_in( $_SESSION["datos_usuario"]["ID_USUARIO"] );
		// $this->sessionManagerService->verify_token( strip_tags($_REQUEST['TOKEN']) );
		$this->sessionManagerService->ValidateSessionSecurity( $_SESSION["datos_usuario"]["ID_USUARIO"], $_SESSION["token"] );

		$id_publicador = (!empty($_POST["id_publicador"])) ? $_POST["id_publicador"] : 0 ;

		$json_data_publicador =  $this->classPublicador->obtener_info_publicador_por_id( $id_publicador );

		$datos['datos_publicador'] = json_decode($json_data_publicador['JSON_DATA_PUBLICADOR'], true);

		// print_r($datos['datos_publicador']);

		$status = ( empty($datos['datos_publicador']) ) ? 'error' : 'success' ;

		$envioDatos["status"] = $status;
		$envioDatos["arrayDatos"] = $datos['datos_publicador'];

		echo json_encode($envioDatos);
	}

}

?>