<?php 
	require_once($config->get('baseDir').'Router.php');
	$ruta = new Router();
	
	if(isset($_SESSION["login_time"]) && (time()-$_SESSION['login_time'] > $config->get('max_time_session'))){ //Condicion para evitar que la session inactiva, tenga mas de 15 minutos
		echo 'alert("Sesion expirada");';
		session_destroy();
		header('Location: ');
		exit;
	}else
	if(!isset($_SESSION["login_token"])){ 
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
		
	}else{ 
		$enlace = $ruta->enlace();
		switch ($enlace[1]){
			case 'salir':
				if(isset($_SESSION['login_token'])){
					session_destroy();
					header('Location: /inicio');
					exit;
				}
				break;

			/*case 'usuarios':
				require_once($config->get('controllersDir').'Usuarios.php');
				$Usuarios = new Usuarios($config);
				if($Usuarios->obtenerModulo($_SESSION['id_usuario'], 10100) < 1){ 
					echo 'No autorizado';
					return 1;
				}
				break;

			case 'proveedores':
				require_once($config->get('controllersDir').'Usuarios.php');
				$Usuarios = new Usuarios($config);
				if($Usuarios->obtenerModulo($_SESSION['id_usuario'], 10200) < 1){ 
					echo 'No autorizado';
					return 1;
				}
				break;
			
			case 'bancos':
				require_once($config->get('controllersDir').'Usuarios.php');
				$Usuarios = new Usuarios($config);
				if($Usuarios->obtenerModulo($_SESSION['id_usuario'], 10300) < 1){ 
					echo 'No autorizado';
					return 1;
				}
				if($Usuarios->obtenerModulo($_SESSION['id_usuario'], 10301) < 1){ 
					echo 'No autorizado';
					return 1;
				}
				break;
			
			case 'cuentas':
				require_once($config->get('controllersDir').'Usuarios.php');
				$Usuarios = new Usuarios($config);
				if($Usuarios->obtenerModulo($_SESSION['id_usuario'], 10302) < 1){ 
					echo 'No autorizado';
					return 1;
				}
				break;*/

			/*case 'cheques':
				require_once($config->get('controllersDir').'Usuarios.php');
				$Usuarios = new Usuarios($config);
				if($Usuarios->obtenerModulo($_SESSION['id_usuario'], 10400) < 1){ 
					echo 'No autorizado';
					return 1;
				}
				break;*/
		}
		
		if($ruta->get() == 'GET'){
			$enlace = $ruta->enlace();
			switch ($enlace[1]){
				/**
				 * Ruta para hacer el logout, pendiente de validar el cerrado de session
				 */
				case 'hash':
					echo hash('sha256', 'S0p42021');
					require_once($config->get('controllersDir').'Cheques.php');
					$Cheques = new Cheques($config);
					echo $Cheques->info(1651, '2021-01-01', 500, '165465465', 3, 1, 'asdf');
					break;

				case 'salir':
					if(isset($_SESSION['login_token'])){
						session_destroy();
						header('Location: /inicio');
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

						case 'auditoria':
							require_once($config->get('controllersDir').'Cheques.php');
							$Cheques = new Cheques($config);
							echo $Cheques->liberarAuditoria($enlace[3]);
							break;

						case 'gerencia':
							require_once($config->get('controllersDir').'Cheques.php');
							$Cheques = new Cheques($config);
							echo $Cheques->liberarGerencia($enlace[3]);
							break;

						case 'impresion':
							require_once($config->get('controllersDir').'Cheques.php');
							$Cheques = new Cheques($config);
							echo $Cheques->imprimirCheque($enlace[3]);
							break;

						case 'entregar':
							require_once($config->get('controllersDir').'Cheques.php');
							$Cheques = new Cheques($config);
							echo $Cheques->entregarCheque($enlace[3]);
							break;

						default:
							require_once($config->get('controllersDir').'Cheques.php');
							$Cheques = new Cheques($config);
							echo $Cheques->obtenerCheque($enlace[2]);
							break;
					}
					break;
				
				case 'bitcheque':
					require_once($config->get('controllersDir').'Bitacoras.php');
					$Bitacoras = new Bitacoras($config);
					return $Bitacoras->listaBitacoraCheque();
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
	}
 ?>