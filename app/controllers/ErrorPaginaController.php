<?php
//session_start();

//Heredamos Controlador para poder tener acceso al método modelo y método vista
class ErrorPagina extends Controller {

	private $controlador = "ErrorPagina";
    private $carpeta_vista = "error";

	public function __construct() {

	}

	//Todo controlador debe tener un metodo index
	public function index() 
	{
        http_response_code(404);
		$this->view($this->carpeta_vista.'/Error404');
	}

}

?>