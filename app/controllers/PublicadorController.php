<?php
//session_start();

//Heredamos Controlador para poder tener acceso al método modelo y método vista
class Publicador extends Controller 
{

	private $sessionManager;
	// private $catalogoService;
	private $publicadorService;

	public function __construct()
	{
		$this->sessionManager = new SessionManager();
		// $this->catalogoService = new CatalogoService();
		$this->publicadorService = new PublicadorService();
	}


	//Todo controlador debe tener un metodo index
	public function index() 
	{
		
	}


	public function data_table_list_catalogo()
	{
		$requestData = [
			"row"    => $_POST['start'],
			"rows"   => $_POST['length'],
			"search" => $_POST['search']['value']
		];
		$this->publicadorService->getDataTableListCatalogo($requestData);
	}

	/* public function data_table_list_catalogo()
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
	} */

}

?>