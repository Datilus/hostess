<?php

class SessionManager
{
	private $usuarioRepository;

    public function __construct()
	{
		$this->usuarioRepository = new UsuarioRepository();
	}


    public function is_logged_in( $cve_usuario )
	{
		if ( empty($cve_usuario) || $this->usuarioRepository->findByConcatString(4, $cve_usuario)['RESULTADO'] == false )
            $this->close_session_login();
        
	}


    public function verify_token( $token = '' )
	{
		if ( $token == '' ){

			if ( empty($_SESSION["token"]) )
                $this->close_session_login();
		}else{

			if ( $token != $_SESSION["token"] || empty($_SESSION["token"]) )
                $this->close_session_login();
		}
		
	}


	/**
	* @param $permisos (array) array de permisos asignados 
	* @param $tipo_output (int) tipo de salida de la funcion para validar  0 = Solo mensaje, 1 = Json de datos
	*/
	public function CheckPermission( $parameters = [], $tipo_output )
	{
		$dataParameters = array(
			"permisos" => [], 
			"tipo_output" => false
		);

		$dataParameters = array_merge($dataParameters, $parameters);

		// Inicializamos una variable de bandera para rastrear si se encuentra algún valor
		$encontrado = false;

		// Recorremos el primer array
		foreach ($dataParameters['permisos'] as $valor) {
			// Si el valor existe en el segundo array, establecemos la bandera a true y salimos del bucle
			if ( in_array($valor, $_SESSION["permisos"]) ) {
				
				$encontrado = true;
				break;
			}
		}

		if ( $encontrado == false && $tipo_output == 1 ){

			throw new DataStatusResponse( true, 0, 'Permiso denegado.', 201, ['status_msg' => 'error'] );
		}elseif ( $encontrado == false && $tipo_output == 0 ) {

			die('Permiso denegado');
		}
	}


    public function close_session()
	{
		session_unset();
		session_destroy(); 

		throw new DataStatusResponse( false, 0, 'Sesión cerrada.', 201, ['session_on' => false] );
	}


	public function close_session_login()
	{
		session_unset();
		session_destroy(); 

		die(header("Location: " . RUTA_URL . "login"));
	}

}