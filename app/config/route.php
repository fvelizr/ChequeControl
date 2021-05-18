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
	}else if(!isset($_SESSION["login_token"])){ 
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
		/**
		 * Se obtiene el enlace de la dirección web y se divide
		 * para poder tratarlas con un switch.
		 *
		 * Por ejemplo si la ruta es http://aplicacion.com/inicio
		 * el post procesado de ruta lo dejaría así:
		 * $enlace[0] = '';
		 * $enlace[1] = 'inicio';
		 *
		 * La ruta raíz de la página por defecto es vacía ''.
		 *
		 * Puedes anidar switches en caso que la ruta tenga 
		 * subdirectorios, por ejemplo http://aplicacion.com/usuario/3
		 * $enlace[0] = "";
		 * $enlace[1] = "usuario";
		 * $enlace[2] = "3";
		 */
		$enlace = $ruta->enlace();

		/**
		 * El Switch utiliza una accion dependiendo de la ruta.
		 */
		
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
				require_once($config->get('controllersDir').'Usuarios.php');
				$usuarios = new Usuarios($config);
				switch($enlace[2]){
					case '':
						return $usuarios->listaUsuarios();
						break;

					case 'crear':
						return $usuarios->crearUsuario();
						break;
					
					case 'editar':
						return $usuarios->editarUsuario();
						break;

					case 'eliminar':
						return $usuarios->eliminar();
						break;

					default:
						echo $usuarios->obtenerUsuario($enlace[2]);
						break;
				}
				break;

			/**
			 * Modulo de Proveedores
			 */
			case 'proveedores':
				require_once($config->get('controllersDir').'Proveedores.php');
				$proveedores = new Proveedores($config);
				return $proveedores->indexAction();
				break;

			/**
			 * Modulo de Bancos
			 */
			case 'bancos':
				require_once($config->get('controllersDir').'Bancos.php');
				$bancos = new Bancos($config);
				return $bancos->indexAction();
				break;

			case 'cuentasbancarias':
				require_once($config->get('controllersDir').'CuentasBancarias.php');
				$cuentas_bancarias = new CuentasBancarias($config);
				return $cuentas_bancarias->indexAction();
				break;

			case 'chequeras':
				require_once($config->get('controllersDir').'Chequeras.php');
				$chequeras = new Chequeras($config);
				return $chequeras->indexAction();
				break;
			
			/**
			 * Modulo de Generacion de Cheques
			 */
			case 'generacioncheques':
				require_once($config->get('controllersDir').'GeneracionCheques.php');
				$generacion_cheques = new GeneracionCheques($config);
				return $generacion_cheques->indexAction();
				break;

			/**
			 * Modulo de Libreacion de Auditoria
			 */
			case 'auditoria':
				require_once($config->get('controllersDir').'Auditoria.php');
				$auditoria = new Auditoria($config);
				return $auditoria->indexAction();
				break;

				//Ruta para configurar el monto maximo sin liberacion de auditoria
			case 'maxautorizado':
				require_once($config->get('controllersDir').'MaxAutorizado.php');
				$max_autorizado = new MaxAutorizado($config);
				return $max_autorizado->indexAction();
				break;

			/**
			 * Modulo de Liberacion de Gerencia
			 */
			case 'gerencia':
				require_once($config->get('controllersDir').'Gerencia.php');
				$gerencia = new Gerencia($config);
				return $gerencia->indexAction();
				break;
			
			/**
			 * Modulo de Impresion o Entrega
			 */
			case 'caja':
				require_once($config->get('controllersDir').'Caja.php');
				$cuentas_bancarias = new CuentasBancarias($config);
				return $cuentas_bancarias->indexAction();
				break;
			
			
			case 'home':
				/**
				 * Se llama y se crea un objeto de la clase Home 
				 * para este ejemplo
				 */
				require_once($config->get('controllersDir').'Home.php');
				$home = new Home($config);

				/**
				 * Se llama y retorna la función indexAction() de la clase
				 * Home
				 */
				return $home->indexAction();
				break; // Se finaliza el switch
			/**
			 * Si la direción es /hola, se hace un echo con hola y
			 * se termina el switch
			 */
			case 'hola': 
				echo "hola";
				break;
			
			default:
				# code
				echo "ERROR 404: NOT FOUND";
				break;
		}

	}elseif($ruta->get() == 'POST'){
		$enlace = $ruta->enlace();
		switch($enlace[1]){
			case 'usuarios':
				require_once($config->get('controllersDir').'Usuarios.php');
				$usuarios = new Usuarios($config);
				echo $usuarios->crearUsuario();
				break;
		}
		/*switch($_POST['solicitud']){
			case 'crearToken':
				require_once($config->get('controllersDir').'Login.php');
				$controlador = new Login($config);
				echo $controlador->crearToken(2);
				break;
	
			case 'verificarToken':
				require_once($config->get('controllersDir').'Login.php');
				$controlador = new Login($config);
				return $controlador->verificarToken(1);
				break;
		}*/
		
		/**
		 * No está implementado, pero es similar a los pasos del
		 * Método GET con el switch
		 */
	}else if($ruta->get() == 'PUT'){
		$enlace = $ruta->enlace();
		switch($enlace[1]){
			case 'usuarios':
				require_once($config->get('controllersDir').'Usuarios.php');
				$usuarios = new Usuarios($config);
				echo $usuarios->editarUsuario();
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