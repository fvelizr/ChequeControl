<?php

/**
 * En caso que no tome el directorio de la aplicación,
 * en esta linea se vuelve a definir
 */
defined('APP_PATH') || define('APP_PATH', realpath('.'));

/**
 * Se importa la clase Config desde las librerías Base,
 * y se generan las variables de configuración
 */
require_once(APP_PATH.'/app/base/Config.php');
$config = Config::singleton();

/**
 * Se agregan las distintas configuraciones que se requiera, 
 * estas son algunas básicas, en breve su descripción
 */

$config->set('controllersDir', APP_PATH . '/app/controllers/'); //Directorio de los controladores
$config->set('modelsDir', APP_PATH . '/app/models/'); // Directorio de los Modelos
$config->set('viewsDir', APP_PATH . '/app/views/'); // Directorio de las vistas
$config->set('viewsDirCss', APP_PATH . '/app/views/css'); // Directorio de las vistas
$config->set('baseDir', APP_PATH . '/app/base/'); // Directorio de las librerías base
$config->set('configDir', APP_PATH . '/app/config/'); //Directorio de Configuraciones y cargadores
$config->set('baseUri', '/'); // Directorio raíz de la aplicación
$config->set('baseUrl', 'chequecontrol.com'); // Página web base a la que pertenece
 
$config->set('adapter', 'oci'); // Driver de base de datos (puede cambiar a los drives que se mencionan en config/loader.php)
$config->set('host', 'localhost'); // Dirección del servidor de la Base de datos
$config->set('username', 'prueba'); // Usuario de la Base de datos
$config->set('password', 'prueba'); // Contraseña de la base de datos
//$config->set('dbname', '//localhost:1521/XE'); // Nombre de la base de datos
$config->set('dbname', '//localhost:1521/XE'); // Nombre de la base de datos
//$config->set('charset', 'utf8'); // Codificación de la base de datos

$config->set('max_time_session',900);

/*
Se inicia la sesion para que el sistema.
*/
session_start();

/**
 * Asigna la zona horaria predeterminada del servidor
 */

date_default_timezone_set('UTC');

return $config;
?>
