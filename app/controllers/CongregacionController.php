<?php

//Heredamos Controlador para poder tener acceso al método modelo y método vista
class Congregacion extends Controller {

	private $controlador = "Congregacion";

	private $modelCatalogo;

	private $classCongregacion,
			$classSessionManager;

	public function __construct() {

		$this->classCongregacion = new _Congregacion();
		$this->classSessionManager = new SessionManager();

		$this->modelCatalogo = $this->model('CatalogoModel');
	}


	//Todo controlador debe tener un metodo index
	public function index() 
	{
		// Validar sesión activa y permiso de acceso
		$this->classSessionManager->is_logged_in( $_SESSION["datos_usuario"]["ID_USUARIO"] );

		$this->classSessionManager->CheckPermission( ["permisos" => [7]], 0 );

		$datos['colonias'] = $this->modelCatalogo->obtenerColonias(['ban'=> 'GETCOL', 'opciones' => ['tipo'=> "L"]]);

		$this->view('congregacion/Congregacion', $datos);
	}


	public function consultarCongregacion()
	{
		$this->classSessionManager->is_logged_in( $_SESSION["datos_usuario"]["ID_USUARIO"] );

		$this->classSessionManager->verify_token( strip_tags($_REQUEST['TOKEN']) );
		
		$this->view('congregacion/consultarCongregacion');
	}


	public function editar($parametrosURL)
	{
		$this->classSessionManager->is_logged_in( $_SESSION["datos_usuario"]["ID_USUARIO"] );

		$this->classSessionManager->verify_token( strip_tags($_REQUEST['TOKEN']) );

		$this->classSessionManager->CheckPermission( ["permisos" => [8]], 0 );

		$datos['colonias'] = $this->modelCatalogo->obtenerColonias(['ban'=> 'GETCOL', 'opciones' => ['tipo'=> "L"]]);

		$json_data_congregacion =  $this->classCongregacion->obtener_congregacion_por_id( $parametrosURL[0] );

		$datos['datos_congregacion'] = json_decode($json_data_congregacion['JSON_DATA_CONGREGACION'], true);
		
		$this->view('congregacion/Congregacion', $datos);
	}


	public function guardar() 
	{
		$this->classSessionManager->is_logged_in( $_SESSION["datos_usuario"]["ID_USUARIO"] );

		$this->classSessionManager->verify_token( strip_tags($_REQUEST['TOKEN']) );

		$this->classSessionManager->CheckPermission( ["permisos" => [7,8]], 1 );

		$data_congregacion = [
			'id_congregacion' => $_POST['txt_id_congregacion'],
			'nombre'          => $_POST['txt_congregacion'],
			'calle_salon'     => $_POST['txt_calle_salon'],
			'numero_salon'    => $_POST['txt_numero_domicilio'],
			'codigo_colonia'  => $_POST['cmb_colonia'],
			'telefono_salon'  => $_POST['txt_telefono_salon'],
		];

		$this->classCongregacion->guardar($data_congregacion);

	}


	public function borrar() 
	{
		$this->classSessionManager->is_logged_in( $_SESSION["datos_usuario"]["ID_USUARIO"] );

		$this->classSessionManager->verify_token( strip_tags($_REQUEST['TOKEN']) );

		$this->classSessionManager->CheckPermission( ["permisos" => [9]], 1 );

		$data_congregacion = [
			'id_congregacion' => $_POST['id_congregacion'],
		];

		$this->classCongregacion->borrar($data_congregacion);

	}


	public function data_table_list()
	{
		$data =  array (
			"ban"    => 1,
			"row"    => $_POST['start'],
			"rows"   => $_POST['length'],
			"search" => $_POST['search']['value']
		);
		$json_data = $this->classCongregacion->data_table_list( $data );

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
							<a class='dropdown-item text-muted nav-link' href='#' name='editar' data-id_congregacion='". intval($value['id']) ."'>Editar</a>
						</small>
			";
			// }

			// if ( in_array(9, $_SESSION["permisos"]) === true ){
			$acciones .= "
						<small>
							<a class='dropdown-item text-muted' href='#' name='borrar' data-id_congregacion='". intval($value['id']) ."'>Borrar</a>
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
			$subdatos[] = $value['nombre_congregacion'];
			$subdatos[] = $value['calle_salon'] . ' ' . $value['numero_salon'] . ', ' . $value['colonia'];
			$subdatos[] = $value['telefono_salon'];
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