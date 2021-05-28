<?php 
	/**
	 * Se llama a la clase Router para tratar las rutas
	 * y el tipo de Método que utiliza (POST, GET u otro)
	 */
	require_once($config->get('baseDir').'Router.php');
	$ruta = new Router();

	
	/**
	 * Se separan las rutas por los métodos GET y POST
	 * que son los métodos más utilizados, se pueden 
	 * incorporar otros según se requiera.
	 */
	
	if(isset($_SESSION["login_time"]) && (time()-$_SESSION['login_time'] > $config->get('max_time_session'))){ //Condicion para evitar que la session inactiva, tenga mas de 15 minutos
		//Aqui hay que mostrar un alert y hacer la redireccion al inicio.
		echo 'alert("Sesion expirada");';
		session_destroy();
		header('Location: ');
		exit;
	}else
	if(!isset($_SESSION["login_token"])){ 
		/**
		 * Condicion para validar que el usuario este logueado, si no esta logueado, no podra hacer absolutamente nada en el sistema.
		 * Importante: cuando ya este la vista y la base de datos hay que modificar las funciones de verificarDatos para que haga las consultas a la base de datos.
		 */
		$enlace = $ruta->enlace(); //Se utiliza para setear la url
		switch ($enlace[1]){
			case 'validarIngreso':
				require_once($config->get('controllersDir').'Validacion.php');
				$Validacion = new Validacion($config);
				echo $Validacion->validarIngreso();
				break;

			default:
				require_once($config->get('controllersDir').'Validacion.php');
				$Validacion = new Validacion($config);
				return $Validacion->indexAction();
				break;
		}
		
	}else if($ruta->get() == 'GET'){
		$enlace = $ruta->enlace();
		switch ($enlace[1]){
			/**
			 * Ruta para hacer el logout, pendiente de validar el cerrado de session
			 */
			case 'hash':
				echo hash('sha256', 'edmundo');
				break;

			case 'salir':
				if(isset($_SESSION['login_token'])){
					session_destroy();
					header('Location: /');
					exit;
				}

				session_destroy();
				break;

			case '':
			case 'inicio':
				require_once($config->get('controllersDir').'Inicio.php');
				$inicio = new Inicio($config);
				return $inicio->indexAction();
				break;
			
			/**
			 * Modulo de Usuarios
			 */
			case 'usuarios':
				switch($enlace[2]){
					case '':
						require_once($config->get('controllersDir').'Usuarios.php');
						$usuarios = new Usuarios($config);
						return $usuarios->listaUsuarios();
						break;

					default:
						require_once($config->get('controllersDir').'Usuarios.php');
						$usuarios = new Usuarios($config);
						echo $usuarios->obtenerUsuario($enlace[2]);
						break;
				}
				
				break;

			/**
			 * Modulo de Proveedores
			 */
			case 'proveedores':
				switch($enlace[2]){
					case '':
						require_once($config->get('controllersDir').'Proveedores.php');
						$proveedores = new Proveedores($config);
						return $proveedores->listaProveedores();
						break;

					default:
						require_once($config->get('controllersDir').'Proveedores.php');
						$proveedores = new Proveedores($config);
						echo $proveedores->obtenerProveedor($enlace[2]);
						break;
				}
				
				break;

			case 'cuentas':
				switch($enlace[2]){
					case '':
						require_once($config->get('controllersDir').'Cuentas.php');
						$cuentas = new Cuentas($config);
						return $cuentas->listaCuentas();
						break;

					default:
						require_once($config->get('controllersDir').'Cuentas.php');
						$cuentas = new Cuentas($config);
						echo $cuentas->obtenerCuenta($enlace[2]);
						break;
				}
				break;

			case 'cheques':
				switch($enlace[2]){
					case '':
						require_once($config->get('controllersDir').'Cheques.php');
						$Cheques = new Cheques($config);
						return $Cheques->listaCheques();
						break;

					case 'cuentas':
						require_once($config->get('controllersDir').'Cheques.php');
						$Cheques = new Cheques($config);
						echo $Cheques->obtenerCuentas($enlace[3]);
						break;

					default:
						require_once($config->get('controllersDir').'Cheques.php');
						$Cheques = new Cheques($config);
						echo $Cheques->obtenerCheque($enlace[2]);
						break;
				}
				break;
			
			default:
				# code
				echo "ERROR 404: NOT FOUND";
				break;
		}
	}else if($ruta->get() == 'POST'){
		$enlace = $ruta->enlace();
		switch($enlace[1]){
			case 'usuarios':
				require_once($config->get('controllersDir').'Usuarios.php');
				$usuarios = new Usuarios($config);
				echo $usuarios->crearUsuario();
				break;

			case 'proveedores':
				require_once($config->get('controllersDir').'Proveedores.php');
				$Proveedores = new Proveedores($config);
				echo $Proveedores->crearProveedor();
				break;

			case 'cuentas':
				require_once($config->get('controllersDir').'Cuentas.php');
				$Cuentas = new Cuentas($config);
				echo $Cuentas->crearCuenta();
				break;

			case 'cheques':
				require_once($config->get('controllersDir').'Cheques.php');
				$Cheques = new Cheques($config);
				echo $Cheques->crearCheque();
				break;
		}
	}else if($ruta->get() == 'PUT'){
		$enlace = $ruta->enlace();
		switch($enlace[1]){
			case 'usuarios':
				require_once($config->get('controllersDir').'Usuarios.php');
				$usuarios = new Usuarios($config);
				echo $usuarios->editarUsuario();
				break;

			case 'proveedores':
				require_once($config->get('controllersDir').'Proveedores.php');
				$proveedores = new Proveedores($config);
				echo $proveedores->editarProveedor();
				break;

			case 'cuentas':
				require_once($config->get('controllersDir').'Cuentas.php');
				$Cuentas = new Cuentas($config);
				echo $Cuentas->editarCuenta();
				break;

			case 'cheques':
				require_once($config->get('controllersDir').'Cheques.php');
				$Cheques = new Cheques($config);
				echo $Cheques->editarCheque();
				break;

			default:
				break;
		}
	}else if($ruta->get() == 'DELETE'){
		$enlace = $ruta->enlace();
		switch($enlace[1]){
			case 'usuarios':
				require_once($config->get('controllersDir').'Usuarios.php');
				$usuarios = new Usuarios($config);
				echo $usuarios->eliminarUsuario();
				break;

			default:
				break;
		}
	}
 ?>