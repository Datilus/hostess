<?php

//Clase controlador principal
//Se encarga de poder cargar los modelos y vistas
class Controller
{
	//cargar modelo
	/* public function model($modelo)
	{
		//echo '../app/models/' . $modelo . '.php';
		require_once '../app/models/' . $modelo . '.php';

		//Instanciamos modelo
		return new $modelo();
	} */


	//cargar vista
	public function view($vista, $datos = [])
	{
		//Checar si el archivo vista existe
		//echo '../app/views/' . $vista . '.php';
		if (file_exists('../app/views/' . $vista . '.php'))
		{
			//En otras estructuras MVC es como hacer un render
			require_once '../app/views/' . $vista . '.php';
		}else{
			die('La vista no existe.');
		}
	}
}


?>