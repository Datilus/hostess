<?php

// El iniciador es el que se encargara de cargar todos los archivos 
// necesarios de la misma carpeta app y este mismo se la pasara al index
//error_reporting(0);

// Inicializamos Fecha y Hora local
date_default_timezone_set('America/Mazatlan');

// Cargamos librerias
require_once 'config/Configurar.php';

// Usamos el Autoload para no tener que anidar librerias como arriba
// esto es por si el sistema se hace robusto...

function autoloadCore($nombreClase)
{
	if ( file_exists('../app/core/' . $nombreClase . '.php') ) {
        require_once 'core/' . $nombreClase . '.php';
    }
}


function autoloadClass($nombreClase)
{
	if ( file_exists('../app/class/' . $nombreClase . '.php') ) {
        require_once 'class/' . $nombreClase . '.php';
    }
}


function autoloadModels($nombreClase)
{
	if ( file_exists('../app/models/' . $nombreClase . '.php') ) {
        require_once 'models/' . $nombreClase . '.php';
    }
}


function autoloadRepositories($nombreClase)
{
	if ( file_exists('../app/repositories/' . $nombreClase . '.php') ) {
        require_once 'repositories/' . $nombreClase . '.php';
    }
}


function autoloadServices($nombreClase)
{
	if ( file_exists('../app/services/' . $nombreClase . '.php') ) {
        require_once 'services/' . $nombreClase . '.php';
    }
}


function autoloadHelpers($nombreClase)
{
	if ( file_exists('../app/helpers/' . $nombreClase . '.php') ) {
        require_once 'helpers/' . $nombreClase . '.php';
    }
}


// Autoload core
spl_autoload_register('autoloadCore');

// Autoload class
spl_autoload_register('autoloadClass');

// Autoload model
spl_autoload_register('autoloadModels');

// Autoload repository
spl_autoload_register('autoloadRepositories');

// Autoload services
spl_autoload_register('autoloadServices');

// Autoload helpers
spl_autoload_register('autoloadHelpers');

?>